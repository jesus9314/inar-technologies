<?php

return [
    'title' => 'Centro de Configuración',
    'group' => 'General',
    'back' => 'Atrás',
    'settings' => [
        'site' => [
            'title' => 'Configuración del Sitio',
            'description' => 'Gestiona la configuración de tu sitio',
            'form' => [
                'site_name' => 'Nombre del Sitio',
                'site_description' => 'Descripción del Sitio',
                'site_logo' => 'Logo del Sitio',
                'site_profile' => 'Imagen de Perfil del Sitio',
                'site_keywords' => 'Palabras Clave del Sitio',
                'site_email' => 'Correo Electrónico del Sitio',
                'site_phone' => 'Teléfono del Sitio',
                'site_author' => 'Autor del Sitio',
            ],
            'site-map' => 'Generar Mapa del Sitio',
            'site-map-notification' => 'Mapa del Sitio Generado Correctamente',
        ],
        'social' => [
            'title' => 'Menú Social',
            'description' => 'Gestiona tu menú social',
            'form' => [
                'site_social' => 'Enlaces Sociales',
                'vendor' => 'Proveedor',
                'link' => 'Enlace',
            ],
        ],
        'location' => [
            'title' => 'Configuración de Ubicación',
            'description' => 'Gestiona la configuración de ubicación',
            'form' => [
                'site_address' => 'Dirección del Sitio',
                'site_phone_code' => 'Código Telefónico del Sitio',
                'site_location' => 'Ubicación del Sitio',
                'site_currency' => 'Moneda del Sitio',
                'site_language' => 'Idioma del Sitio',
            ],
        ],
    ],
];