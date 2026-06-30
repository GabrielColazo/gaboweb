<?php
defined('ACCESO_SEGURO') or die('Acceso denegado');

$config = [
    'smtp' => [
        'host'       => 'a0130306.ferozo.com',
        'auth'       => true,
        'username'   => 'contacto@gaboweb.com.ar',
        'password'   => 'REEMPLAZAR_EN_SERVIDOR',
        'secure'     => 'ssl',
        'port'       => 465,
        'debug'      => 1,
        'from_name'  => 'GaboWeb - Formulario Web',
        'recipient'  => 'contacto@gaboweb.com.ar'
    ],

    'recaptcha' => [
        'activo'     => false,
        'site_key'   => '',
        'secret_key' => ''
    ],

    'campos' => [
        'nombre'    => ['activo' => true,  'requerido' => true],
        'apellido'  => ['activo' => false, 'requerido' => false],
        'email'     => ['activo' => true,  'requerido' => true],
        'telefono'  => ['activo' => false, 'requerido' => false],
        'direccion' => ['activo' => false, 'requerido' => false],
        'pais'      => ['activo' => false, 'requerido' => false],
        'mensaje'   => ['activo' => true,  'requerido' => true],
        'asunto'    => ['activo' => true,  'requerido' => true],
        'adjuntos'  => ['activo' => false, 'requerido' => false]
    ],

    'seguridad' => [
        'permitir_adjuntos' => false,
        'tipos_permitidos'  => [],
        'max_size_mb'       => 0,
        'tiempo_minimo'     => 3,
        'honey_pot_field'   => 'website_check'
    ]
];

// Cargar configuración sensible desde archivo fuera del repo (no en git)
$sensitiveFile = __DIR__ . '/config_sensitive.php';
if (file_exists($sensitiveFile)) {
    $sensitive = require $sensitiveFile;
    if (isset($sensitive['password'])) {
        $config['smtp']['password'] = $sensitive['password'];
    }
}

return $config;
