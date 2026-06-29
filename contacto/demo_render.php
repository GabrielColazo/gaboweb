<?php
/**
 * RENDERIZADOR DE DEMOSTRACIONES (12 VARIANTES)
 * Incluye estilos Retro, Orgánico, High Contrast y más.
 */
define('ACCESO_SEGURO', true);

// 1. Cargar Configuración Base
$ruta_config_app = __DIR__ . '/../../private_config/config_app.php';
$ruta_config_design = __DIR__ . '/../../private_config/config_design.php';

if (!file_exists($ruta_config_app)) {
    $ruta_config_app = __DIR__ . '/config/config_app.php';
    $ruta_config_design = __DIR__ . '/config/config_design.php';
}

$conf = require $ruta_config_app;
$design = require $ruta_config_design;

// 2. Lógica de Variantes
$variant = $_GET['variant'] ?? 'donweb';
$layout_mode = 'stacked';

switch ($variant) {
    // --- 1. CORPORATIVO ---
    case 'donweb':
        $design['colores']['primario'] = '#004593';
        $design['colores']['boton_bg'] = '#FF6600';
        $design['estilos']['bordes_redondeados'] = '6px';
        break;

    // --- 2. DARK SAAS ---
    case 'dark':
        $design['colores']['primario'] = '#818cf8';
        $design['colores']['boton_bg'] = '#6366f1';
        $design['colores']['boton_texto'] = '#ffffff';
        $design['colores']['fondo_pagina'] = '#0f172a';
        $design['colores']['fondo_form'] = '#1e293b';
        $design['colores']['texto_titulo'] = '#f8fafc';
        $design['colores']['texto_label'] = '#94a3b8';
        $design['colores']['borde_input'] = '#334155';
        $design['estilos']['bordes_redondeados'] = '12px';
        break;

    // --- 3. WIDE GRID ---
    case 'wide':
        $layout_mode = 'grid';
        $design['colores']['primario'] = '#0284c7'; // Sky 600
        $design['colores']['boton_bg'] = '#0284c7';
        $design['estilos']['sombra_form'] = '0 25px 50px -12px rgba(0, 0, 0, 0.25)';
        $design['estilos']['bordes_redondeados'] = '16px';
        break;

    // --- 4. ELEGANT SERIF ---
    case 'elegant':
        $design['estilos']['fuente_principal'] = '"Playfair Display", Georgia, serif';
        $design['colores']['primario'] = '#44403c'; // Stone
        $design['colores']['boton_bg'] = '#44403c';
        $design['colores']['fondo_pagina'] = '#f5f5f4';
        $design['colores']['fondo_form'] = '#fff';
        $design['estilos']['bordes_redondeados'] = '2px';
        $design['textos']['titulo'] = 'Atención al Cliente';
        break;

    // --- 5. MINIMALIST ---
    case 'minimal':
        $design['colores']['primario'] = '#000';
        $design['colores']['boton_bg'] = '#000';
        $design['colores']['fondo_pagina'] = '#fff';
        $design['estilos']['sombra_form'] = 'none';
        $design['colores']['borde_input'] = '#e5e5e5';
        $design['estilos']['bordes_redondeados'] = '0px';
        break;

    // --- 6. GLASSMORPHISM ---
    case 'glass':
        $design['colores']['fondo_pagina'] = 'linear-gradient(135deg, #f6d365 0%, #fda085 100%)';
        $design['colores']['primario'] = '#fff';
        $design['colores']['texto_titulo'] = '#fff';
        $design['colores']['texto_label'] = '#fff';
        $design['colores']['boton_bg'] = 'rgba(255,255,255,0.3)';
        $design['estilos']['bordes_redondeados'] = '20px';
        break;

    // --- 7. COMPACT SIDEBAR ---
    case 'compact':
        $design['colores']['primario'] = '#10b981';
        $design['colores']['boton_bg'] = '#10b981';
        $design['textos']['titulo'] = 'Ayuda';
        $design['estilos']['bordes_redondeados'] = '8px';
        break;

    // --- 8. OUTLINE POP ---
    case 'outline':
        $layout_mode = 'grid';
        $design['colores']['primario'] = '#db2777';
        $design['colores']['boton_bg'] = '#fff';
        $design['colores']['boton_texto'] = '#db2777';
        $design['estilos']['bordes_redondeados'] = '30px';
        break;

    // --- 9. BIG TYPO ---
    case 'big':
        $layout_mode = 'grid';
        $design['colores']['primario'] = '#4f46e5';
        $design['colores']['fondo_pagina'] = '#f1f5f9';
        $design['estilos']['bordes_redondeados'] = '24px';
        break;

    // --- 10. SOFT NEUMORPHISM ---
    case 'soft':
        $design['colores']['fondo_pagina'] = '#e0e5ec';
        $design['colores']['fondo_form'] = '#e0e5ec';
        $design['colores']['primario'] = '#7986cb'; // Cool Blue
        $design['colores']['boton_bg'] = '#7986cb';
        $design['estilos']['sombra_form'] = '9px 9px 16px rgb(163,177,198,0.6), -9px -9px 16px rgba(255,255,255, 0.5)';
        $design['estilos']['bordes_inputs'] = '50px'; // Inputs redondos
        break;

    // --- 11. RETRO TERMINAL (Nuevo) ---
    case 'retro':
        $design['estilos']['fuente_principal'] = '"Fira Code", monospace';
        $design['colores']['primario'] = '#00ff41'; // Matrix Green
        $design['colores']['primario_hover'] = '#008f11';
        $design['colores']['boton_bg'] = '#000';
        $design['colores']['boton_texto'] = '#00ff41'; // Texto verde
        $design['colores']['fondo_pagina'] = '#000';
        $design['colores']['fondo_form'] = '#111';
        $design['colores']['texto_titulo'] = '#00ff41';
        $design['colores']['texto_label'] = '#00ff41';
        $design['colores']['borde_input'] = '#00ff41';
        $design['estilos']['bordes_redondeados'] = '0px';
        $design['estilos']['sombra_form'] = '0 0 10px rgba(0, 255, 65, 0.2)';
        $design['textos']['titulo'] = '> INICIAR_COMUNICACION_';
        break;

    // --- 12. SUNNY PLAYFUL (Nuevo) ---
    case 'sunny':
        $layout_mode = 'grid';
        $design['estilos']['fuente_principal'] = '"Quicksand", sans-serif';
        $design['colores']['primario'] = '#fbbf24'; // Amber
        $design['colores']['primario_hover'] = '#f59e0b';
        $design['colores']['boton_bg'] = '#8b5cf6'; // Violeta vibrante
        $design['colores']['fondo_pagina'] = '#fffbeb'; // Crema
        $design['colores']['fondo_form'] = '#fff';
        $design['colores']['texto_titulo'] = '#78350f'; // Marrón oscuro
        $design['estilos']['bordes_redondeados'] = '24px';
        $design['estilos']['sombra_form'] = '4px 4px 0px #fbbf24'; // Sombra sólida pop
        break;
}

session_start();
if(empty($_SESSION['form_token'])) {
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
    <title>Demo Variant</title>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600&family=Playfair+Display:wght@600&family=Quicksand:wght@500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    
    <style>
        :root {
            /* Variables Dinámicas */
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
            --shadow-card: <?php echo $design['estilos']['sombra_form']; ?>;
        }

        /* Overrides Generales */
        .btn-submit { background-color: var(--btn-bg); color: var(--btn-text); }
        .btn-submit:hover { filter: brightness(110%); }

        /* --- LÓGICA GRID --- */
        <?php if($layout_mode == 'grid'): ?>
            .form-container { max-width: 700px; }
            form { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
            .form-header, .form-feedback, .btn-submit, .form-group:last-of-type, .form-group:nth-last-of-type(2) { grid-column: 1 / -1; }
            .form-group { margin-bottom: 0; }
            @media (max-width: 600px) { form { grid-template-columns: 1fr; } }
        <?php endif; ?>

        /* --- OVERRIDES ESPECÍFICOS --- */

        <?php if($variant == 'glass'): ?>
            .form-container {
                background: rgba(255, 255, 255, 0.25);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }
            input, textarea, select { background: rgba(255,255,255,0.4); border-color: #fff; color: #fff; }
            input::placeholder { color: #fff; opacity:0.8; }
            .input-icon { fill: #fff; }
        <?php endif; ?>

        <?php if($variant == 'retro'): ?>
            /* Retro Terminal Style */
            .btn-submit { border: 2px solid #00ff41; background: #000; text-transform: uppercase; letter-spacing: 2px; }
            .btn-submit:hover { background: #00ff41; color: #000; }
            input, select, textarea { background: #000; border: 1px solid #333; color: #00ff41; border-radius: 0; }
            .input-icon { fill: #00ff41; }
            .form-header h2:after { content: '▋'; animation: blink 1s infinite; }
            @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }
        <?php endif; ?>

        <?php if($variant == 'sunny'): ?>
            /* Sunny Playful */
            .btn-submit { box-shadow: 4px 4px 0px #4c1d95; transition: all 0.2s; border: 2px solid #4c1d95; }
            .btn-submit:hover { transform: translate(2px, 2px); box-shadow: 2px 2px 0px #4c1d95; }
            .form-container { border: 2px solid #fbbf24; }
            input:focus { border-color: #8b5cf6; box-shadow: none; }
        <?php endif; ?>
        
        <?php if($variant == 'compact'): ?>
            body { align-items: flex-start; padding-top: 20px; }
            .form-container { max-width: 320px; padding: 1.5rem; }
        <?php endif; ?>

        <?php if($variant == 'outline'): ?>
            .btn-submit { border: 2px solid var(--btn-text); background: transparent; font-weight: 800; }
            .btn-submit:hover { background: var(--btn-text); color: #fff; }
            input:focus { border-width: 2px; }
        <?php endif; ?>

        <?php if($variant == 'big'): ?>
            body { font-size: 18px; }
            input, textarea, .btn-submit { padding: 16px; font-size: 1.1rem; }
        <?php endif; ?>

    </style>
</head>
<body>

<div class="form-container">
    <div class="form-header">
        <h2><?php echo $design['textos']['titulo']; ?></h2>
        <?php if(!empty($design['textos']['subtitulo']) && $variant != 'compact'): ?>
            <p><?php echo $design['textos']['subtitulo']; ?></p>
        <?php endif; ?>
    </div>
    
    <form id="contactForm" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['form_token']; ?>">
        <div style="display:none; opacity:0; visibility:hidden; height:0;">
            <input type="text" name="<?php echo $conf['seguridad']['honey_pot_field']; ?>">
        </div>

        <?php if($conf['campos']['nombre']['activo']): ?>
        <div class="form-group">
            <label>Nombre</label>
            <div class="input-wrapper">
                <svg class="input-icon" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                <input type="text" name="nombre" placeholder="Nombre" required>
            </div>
        </div>
        <?php endif; ?>

        <?php if($conf['campos']['apellido']['activo']): ?>
        <div class="form-group">
            <label>Apellido</label>
            <div class="input-wrapper">
                <svg class="input-icon" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                <input type="text" name="apellido" placeholder="Apellido" required>
            </div>
        </div>
        <?php endif; ?>

        <div class="form-group">
            <label>Email</label>
            <div class="input-wrapper">
                <svg class="input-icon" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                <input type="email" name="email" placeholder="Email" required>
            </div>
        </div>

        <?php if($conf['campos']['telefono']['activo']): ?>
        <div class="form-group">
            <label>Teléfono</label>
            <div class="input-wrapper">
                 <svg class="input-icon" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                <input type="tel" name="telefono" placeholder="+54 9..." required>
            </div>
        </div>
        <?php endif; ?>

        <?php if($variant != 'compact'): ?>
        <div class="form-group">
            <label>Mensaje</label>
            <textarea name="mensaje" rows="3" placeholder="Mensaje..."></textarea>
        </div>
        <?php endif; ?>

        <button type="button" class="btn-submit">ENVIAR</button>
    </form>
</div>
</body>
</html>