<?php

return [

    'routes' => [
        'prefix' => 'admin',
        'middlewares' => ['web', 'auth', 'xacl']
    ],

    'user_model_path' => '\App\Models\User',

    'docs_defaults' => [

        '__construct' => 'Home',
        'aindex' => 'Index',
        'create' => 'Criar',
        'store' => 'Salvar',
        'show' => 'Ver',
        'edit' => 'Ver/Editar',
        'update' => 'Salvar Edição',
        'destroy' => 'Deletar'
    ],

    'doc_start_pattern' => '@xacl',

    'view' => [
        'extends' => 'gentelelladashboard::layouts.main',
        'section' => 'content'
    ]

];
