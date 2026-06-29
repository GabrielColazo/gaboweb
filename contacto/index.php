<?php
define('ACCESO_SEGURO', true);

// 1. CARGA DE CONFIGURACIÓN (Ruta Local Protegida por .htaccess)
$ruta_config_app    = __DIR__ . '/config/config_app.php';
$ruta_config_design = __DIR__ . '/config/config_design.php';

if (!file_exists($ruta_config_app) || !file_exists($ruta_config_design)) {
    die("<div style='text-align:center; padding:50px; font-family:sans-serif;'>Error Crítico: No se encuentran los archivos de configuración en /config/.</div>");
}

$conf = require $ruta_config_app;
$design = require $ruta_config_design;

session_start();
// Regeneramos token si no existe
if (empty($_SESSION['form_token'])) {
    $_SESSION['form_token'] = bin2hex(random_bytes(32));
    $_SESSION['form_time'] = time();
}

function hex2rgb($hex) {
    $hex = str_replace("#", "", $hex);
    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    return "$r, $g, $b";
}
$primaryRgb = hex2rgb($design['colores']['primario']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $design['textos']['titulo']; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    
    <?php if($conf['recaptcha']['activo']): ?>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php endif; ?>

    <style>
        :root {
            --font-stack: <?php echo $design['estilos']['fuente_principal'] ?? "'Roboto', sans-serif"; ?>;
            --color-primary: <?php echo $design['colores']['primario']; ?>;
            --color-primary-rgb: <?php echo $primaryRgb; ?>;
            
            --btn-bg: <?php echo $design['colores']['boton_bg'] ?? $design['colores']['primario']; ?>;
            --btn-hover: <?php echo $design['colores']['boton_hover'] ?? $design['colores']['primario_hover']; ?>;
            --btn-text: <?php echo $design['colores']['boton_texto'] ?? '#ffffff'; ?>;

            --color-body-bg: <?php echo $design['colores']['fondo_pagina']; ?>;
            --color-form-bg: <?php echo $design['colores']['fondo_form']; ?>;
            
            --color-text-title: <?php echo $design['colores']['texto_titulo']; ?>;
            --color-text-label: <?php echo $design['colores']['texto_label']; ?>;
            --color-border: <?php echo $design['colores']['borde_input']; ?>;
            
            --radius-card: <?php echo $design['estilos']['bordes_redondeados']; ?>;
            --radius-input: <?php echo $design['estilos']['bordes_inputs'] ?? '6px'; ?>;
            --shadow-card: <?php echo $design['estilos']['sombra_form'] ?? '0 10px 25px rgba(0,0,0,0.1)'; ?>;
        }
        /* Ajuste para centrar el captcha si se desea */
        .g-recaptcha { margin-bottom: 15px; display: flex; justify-content: center; }
        /* Sobreescritura de botón */
        .btn-submit { background-color: var(--btn-bg); color: var(--btn-text); }
        .btn-submit:hover { filter: brightness(110%); }
    </style>
</head>
<body>

<div class="form-container">
    <div class="form-header">
        <h2><?php echo $design['textos']['titulo']; ?></h2>
        <?php if(!empty($design['textos']['subtitulo'])): ?>
            <p><?php echo $design['textos']['subtitulo']; ?></p>
        <?php endif; ?>
    </div>
    
    <form id="contactForm" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['form_token']; ?>">
        
        <div style="display:none; opacity:0; visibility:hidden; height:0;">
            <input type="text" name="<?php echo $conf['seguridad']['honey_pot_field']; ?>" autocomplete="off">
        </div>

        <?php if($conf['campos']['nombre']['activo']): ?>
        <div class="form-group">
            <label>Nombre</label>
            <div class="input-wrapper">
                <svg class="input-icon" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                <input type="text" name="nombre" placeholder="Nombre" <?php echo $conf['campos']['nombre']['requerido'] ? 'required' : ''; ?>>
            </div>
        </div>
        <?php endif; ?>

        <?php if($conf['campos']['apellido']['activo']): ?>
        <div class="form-group">
            <label>Apellido</label>
            <div class="input-wrapper">
                <svg class="input-icon" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                <input type="text" name="apellido" placeholder="Apellido" <?php echo $conf['campos']['apellido']['requerido'] ? 'required' : ''; ?>>
            </div>
        </div>
        <?php endif; ?>

        <?php if($conf['campos']['email']['activo']): ?>
        <div class="form-group">
            <label>Email</label>
            <div class="input-wrapper">
                <svg class="input-icon" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                <input type="email" name="email" placeholder="tucorreo@email.com" required>
            </div>
        </div>
        <?php endif; ?>

        <?php if($conf['campos']['telefono']['activo']): ?>
        <div class="form-group">
            <label>Teléfono</label>
            <div class="input-wrapper">
                 <svg class="input-icon" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                <input type="tel" name="telefono" placeholder="+54 9..." <?php echo $conf['campos']['telefono']['requerido'] ? 'required' : ''; ?>>
            </div>
        </div>
        <?php endif; ?>

        <?php if($conf['campos']['direccion']['activo']): ?>
        <div class="form-group">
            <label>Dirección</label>
            <div class="input-wrapper">
                 <svg class="input-icon" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                <input type="text" name="direccion" placeholder="Dirección" <?php echo $conf['campos']['direccion']['requerido'] ? 'required' : ''; ?>>
            </div>
        </div>
        <?php endif; ?>

        <?php if($conf['campos']['mensaje']['activo']): ?>
        <div class="form-group">
            <label>Mensaje</label>
            <textarea name="mensaje" rows="4" placeholder="Escribe aquí tu consulta..." <?php echo $conf['campos']['mensaje']['requerido'] ? 'required' : ''; ?>></textarea>
        </div>
        <?php endif; ?>

        <?php if($conf['campos']['adjuntos']['activo'] && $conf['seguridad']['permitir_adjuntos']): ?>
        <div class="form-group">
            <label>Adjuntar Archivo (Max <?php echo $conf['seguridad']['max_size_mb']; ?>MB)</label>
            <div class="file-upload-zone" id="dropZone">
                <input type="file" name="adjunto" id="adjunto" class="file-upload-native" accept=".<?php echo implode(',.', $conf['seguridad']['tipos_permitidos']); ?>">
                <div class="file-upload-content">
                    <svg class="file-icon" viewBox="0 0 24 24"><path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/></svg>
                    <span id="fileText"><?php echo $design['textos']['archivo_placeholder']; ?></span>
                    <span id="fileName" class="file-name"></span>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if($conf['recaptcha']['activo']): ?>
            <div class="g-recaptcha" data-sitekey="<?php echo $conf['recaptcha']['site_key']; ?>"></div>
        <?php endif; ?>

        <div class="form-feedback" id="formFeedback"></div>

        <button type="submit" id="btnSubmit" class="btn-submit" data-loading-text="<?php echo $design['textos']['boton_cargando']; ?>">
            <?php echo $design['textos']['boton_enviar']; ?>
        </button>
    </form>
</div>

<script src="assets/js/form.js"></script>
<script>
    // JS Mínimo para el input file
    const fileInput = document.getElementById('adjunto');
    const fileNameDisplay = document.getElementById('fileName');
    const fileText = document.getElementById('fileText');
    const dropZone = document.getElementById('dropZone');
    if(fileInput) {
        fileInput.addEventListener('change', function(e) {
            if(e.target.files.length > 0) {
                fileNameDisplay.textContent = e.target.files[0].name;
                fileText.style.display = 'none';
                dropZone.style.borderColor = 'var(--color-primary)';
                dropZone.style.backgroundColor = '#f0f9ff';
            } else {
                fileNameDisplay.textContent = '';
                fileText.style.display = 'inline';
                dropZone.style.borderColor = '';
                dropZone.style.backgroundColor = '';
            }
        });
    }
</script>
</body>
</html>