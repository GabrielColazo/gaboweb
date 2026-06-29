<?php
defined('ACCESO_SEGURO') or die('Acceso denegado');

return [
    'smtp' => [
        'host'       => 'a0130306.ferozo.com',
        'auth'       => true,
        'username'   => 'contacto@gaboweb.com.ar',
        'password'   => '7jdggfwe@K5U',
        'secure'     => 'ssl',
        'port'       => 465,
        'debug'      => 0,
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