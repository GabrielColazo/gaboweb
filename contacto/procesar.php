<?php
/**
 * Procesador de Formulario de Contacto (v3.0)
 * - Configuración Local Protegida
 * - WAF Completo
 * - Google reCAPTCHA v2 (Verificación Server-Side)
 * - Anti-Spam (Honeypot + TimeTrap)
 */

session_start();
header('Content-Type: application/json; charset=utf-8');

$response = ['success' => false, 'message' => ''];

// ==============================================================================
// 1. FUNCIONES DE VALIDACIÓN Y SEGURIDAD
// ==============================================================================

function validarSoloTexto($str) {
    return preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/u', trim($str));
}

function validarTelefono($str) {
    return preg_match('/^[0-9\+\-\s]+$/', trim($str));
}

function detectarPatronesMaliciosos($str) {
    $str_decoded = urldecode($str);
    $analisis = strtolower($str . ' ' . $str_decoded);
    $patrones = [
        '/(\;|\||`|\$|\(|\))(\s)*(ls|cat|wget|curl|ping|uname|whoami|netcat|rm|mv|cp)\b/i',
        '/<script/i', '/javascript:/i', '/vbscript:/i', 
        '/onload=/i', '/onerror=/i', '/onclick=/i',
        '/<iframe/i', '/<object/i', '/<embed/i', 
        '/base64_decode/i', '/data:text\/html/i',
        '/union\s+select/i', '/select\s+.*\s+from/i', 
        '/insert\s+into/i', '/update\s+.*\s+set/i',
        '/or\s+1=1/i', 
        '/<\?php/i', '/eval\(/i', '/system\(/i', 
        '/\.\.\//', '/etc\/passwd/i'
    ];
    foreach ($patrones as $patron) {
        if (preg_match($patron, $str) || preg_match($patron, $str_decoded)) {
            return true;
        }
    }
    return false;
}

function limpiarSalida($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// ==============================================================================
// 2. CARGA DE CONFIGURACIÓN (RUTA LOCAL)
// ==============================================================================

define('ACCESO_SEGURO', true);

// Ahora la ruta es local, dentro de /config/
$ruta_config_app    = __DIR__ . '/config/config_app.php';
$ruta_config_design = __DIR__ . '/config/config_design.php';

if (!file_exists($ruta_config_app) || !file_exists($ruta_config_design)) {
    echo json_encode(['success' => false, 'message' => 'Error 500: Falta configuración.']);
    exit;
}

$conf = require $ruta_config_app;
$design = require $ruta_config_design;

require __DIR__ . '/vendor/phpmailer/src/Exception.php';
require __DIR__ . '/vendor/phpmailer/src/PHPMailer.php';
require __DIR__ . '/vendor/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

try {
    // ==========================================================================
    // 3. FASE DE VERIFICACIÓN (Pre-Procesamiento)
    // ==========================================================================

    // A. CSRF Token
    if (empty($_POST['csrf_token']) || empty($_SESSION['form_token']) || !hash_equals($_SESSION['form_token'], $_POST['csrf_token'])) {
        throw new Exception("Error de seguridad: Token inválido. Recargue la página.");
    }

    // B. Honeypot
    $honey_field = $conf['seguridad']['honey_pot_field'] ?? 'website_check';
    if (!empty($_POST[$honey_field])) {
        echo json_encode(['success' => true, 'message' => $design['textos']['exito']]);
        exit;
    }

    // C. Trampa de Tiempo
    $tiempo_minimo = $conf['seguridad']['tiempo_minimo'] ?? 3;
    $tiempo_transcurrido = time() - ($_SESSION['form_time'] ?? 0);
    if ($tiempo_transcurrido < $tiempo_minimo) {
        throw new Exception("Envío bloqueado: Demasiado rápido (posible bot).");
    }

    // D. GOOGLE RECAPTCHA (VERIFICACIÓN)
    if (isset($conf['recaptcha']) && $conf['recaptcha']['activo'] === true) {
        $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';
        $recaptcha_secret   = $conf['recaptcha']['secret_key'];

        if (empty($recaptcha_response)) {
            throw new Exception("Por favor, marca la casilla 'No soy un robot'.");
        }

        // Verificamos contra Google API
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret'   => $recaptcha_secret,
            'response' => $recaptcha_response,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];

        // Usamos CURL para mayor compatibilidad
        $ch = curl_init($verifyUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        // IMPORTANTE: Si estás en local o servidor sin certs actualizados, esto ayuda,
        // pero en producción idealmente debe ser true.
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        $verifyResponse = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($verifyResponse);

        if (!$responseData || !$responseData->success) {
            throw new Exception("Error de verificación reCAPTCHA. Inténtalo de nuevo.");
        }
    }

    // ==========================================================================
    // 4. VALIDACIÓN ESTRICTA DE CAMPOS
    // ==========================================================================
    
    // --- NOMBRE y APELLIDO ---
    if ($conf['campos']['nombre']['activo']) {
        $nombre = $_POST['nombre'] ?? '';
        if (empty($nombre) && $conf['campos']['nombre']['requerido']) throw new Exception("El nombre es obligatorio.");
        if (!empty($nombre) && !validarSoloTexto($nombre)) throw new Exception("El Nombre contiene caracteres no válidos.");
    }

    if ($conf['campos']['apellido']['activo']) {
        $apellido = $_POST['apellido'] ?? '';
        if (empty($apellido) && $conf['campos']['apellido']['requerido']) throw new Exception("El apellido es obligatorio.");
        if (!empty($apellido) && !validarSoloTexto($apellido)) throw new Exception("El Apellido contiene caracteres no válidos.");
    }

    // --- TELÉFONO ---
    if ($conf['campos']['telefono']['activo']) {
        $telefono = $_POST['telefono'] ?? '';
        if (empty($telefono) && $conf['campos']['telefono']['requerido']) throw new Exception("El teléfono es obligatorio.");
        if (!empty($telefono) && !validarTelefono($telefono)) throw new Exception("El Teléfono solo debe contener números.");
    }

    // --- EMAIL ---
    $email = $_POST['email'] ?? '';
    if (empty($email)) throw new Exception("El email es obligatorio.");
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Exception("Formato de email incorrecto.");
    if (preg_match( "/[\r\n]/", $email)) throw new Exception("Intento de inyección en Email.");

    // --- MENSAJE ---
    if ($conf['campos']['mensaje']['activo']) {
        $mensaje = $_POST['mensaje'] ?? '';
        if (empty($mensaje) && $conf['campos']['mensaje']['requerido']) throw new Exception("El mensaje es obligatorio.");
        if (detectarPatronesMaliciosos($mensaje)) throw new Exception("El mensaje contiene caracteres no permitidos.");
    }

    // ==========================================================================
    // 5. CONSTRUCCIÓN DEL CORREO
    // ==========================================================================

    $mensaje_html = "<div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6;'>";
    $mensaje_html .= "<h2 style='color: #004593; border-bottom: 2px solid #ff6600; padding-bottom: 10px;'>Nuevo contacto web</h2>";
    $mensaje_html .= "<table style='width: 100%; border-collapse: collapse;'>";

    $campos_a_procesar = ['nombre', 'apellido', 'email', 'telefono', 'direccion', 'pais', 'mensaje', 'asunto'];

    foreach ($campos_a_procesar as $key) {
        if (isset($conf['campos'][$key]) && $conf['campos'][$key]['activo'] && !empty($_POST[$key])) {
            $valor_limpio = limpiarSalida($_POST[$key]);
            if ($key === 'mensaje') $valor_limpio = nl2br($valor_limpio);

            $mensaje_html .= "<tr>";
            $mensaje_html .= "<td style='padding: 8px; font-weight: bold; width: 150px; background: #f9f9f9;'>" . ucfirst($key) . ":</td>";
            $mensaje_html .= "<td style='padding: 8px;'>" . $valor_limpio . "</td>";
            $mensaje_html .= "</tr>";
        }
    }
    
    $mensaje_html .= "</table>";
    $mensaje_html .= "<div style='margin-top: 20px; font-size: 0.8em; color: #777;'>IP: " . $_SERVER['REMOTE_ADDR'] . "</div>";
    $mensaje_html .= "</div>";

    // ==========================================================================
    // 6. ENVÍO SMTP
    // ==========================================================================

    $mail = new PHPMailer(true);

    // FIX SSL PARA VPS
    $mail->SMTPOptions = array(
        'ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true)
    );

    $mail->isSMTP();
    $mail->Host       = $conf['smtp']['host'];
    $mail->SMTPAuth   = $conf['smtp']['auth'];
    $mail->Username   = $conf['smtp']['username'];
    $mail->Password   = $conf['smtp']['password'];
    $mail->SMTPSecure = $conf['smtp']['secure'];
    $mail->Port       = $conf['smtp']['port'];
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom($conf['smtp']['username'], $conf['smtp']['from_name']);
    $mail->addAddress($conf['smtp']['recipient']);

    // Reply-To Seguro
    $mail->addReplyTo($email, limpiarSalida($_POST['nombre'] ?? 'Usuario'));

    // --- MANEJO DE ADJUNTOS ---
    if (isset($conf['campos']['adjuntos']) && $conf['campos']['adjuntos']['activo'] && $conf['seguridad']['permitir_adjuntos'] && isset($_FILES['adjunto']) && $_FILES['adjunto']['error'] === UPLOAD_ERR_OK) {
        
        $archivo = $_FILES['adjunto'];
        $ext = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        
        if (!in_array($ext, $conf['seguridad']['tipos_permitidos'])) throw new Exception("Tipo de archivo no permitido.");
        
        $max_bytes = $conf['seguridad']['max_size_mb'] * 1024 * 1024;
        if ($archivo['size'] > $max_bytes) throw new Exception("El archivo supera el límite permitido.");

        $nuevo_nombre = 'doc_' . uniqid() . '.' . $ext;
        $mail->addAttachment($archivo['tmp_name'], $nuevo_nombre);
    }

    $mail->isHTML(true);
    $mail->Subject = 'Consulta Web - ' . limpiarSalida($_POST['nombre'] ?? 'Anónimo');
    $mail->Body    = $mensaje_html;
    $mail->AltBody = strip_tags(str_replace(['<br>', '</tr>'], ["\n", "\n"], $mensaje_html));

    $mail->send();

    $response['success'] = true;
    $response['message'] = $design['textos']['exito'];

} catch (Exception $e) {
    $msg = $e->getMessage();
    error_log("[GaboWeb SMTP Error] " . $msg . " | " . ($mail->ErrorInfo ?? 'sin detalle'));
    if (!empty($conf['smtp']['debug']) && $conf['smtp']['debug'] > 0) {
        $response['message'] = "DEBUG: " . $msg . " | " . ($mail->ErrorInfo ?? '');
    } else {
        if (strpos($msg, 'SMTP') !== false || strpos($msg, 'connect') !== false) {
             $response['message'] = $design['textos']['error_gral'];
        } else {
             $response['message'] = $msg; 
        }
    }
}

// Log para debug
error_log("[GaboWeb Formulario] Resultado: " . json_encode($response));

echo json_encode($response);