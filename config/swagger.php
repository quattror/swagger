<?php

return [
    'controller' => [
        'docs_route' => '/docs',
        'view_title' => env('SISTEMA_NOME', 'API Exemplo'),
        'view_env' => env('APP_ENV', 'local'),
        'view_logo' => 'https://cdn.sefaz.es.gov.br/layout/img/brasao_negativo.png',
        'view_favicon' => 'https://cdn.sefaz.es.gov.br/layout/img/favicon.png',
        'proxy' => false,
    ],
    'generator' => [
        'output_dir' => 'swagger',
        'json_file' => 'api.json',
        'annotations_dir' => [
            base_path('app/Http'),
        ],
        'include_app_info' => true,
        'include_git_info' => true,
        'constants' => [
            'TOKEN_KEY' => env('PORTAL_API_TOKEN_KEY', 'exemplotokenkey'),
            'SERVER_URL' => env('APP_URL', 'https://www.exemplo.com.br/api/exemplo'),
            'DESCRIPTION' => env('SISTEMA_DESC', 'API para exemplificar a utilização do swagger')
        ],
        'excluded_dirs' => [],
        'swagger_base' => env('SWAGGER_BASE', null),
    ]
];
