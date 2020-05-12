<?php

return [

    'routes' => [
        'prefix' => 'admin',
        'middlewares' => ['web', 'auth', 'xacl']
    ],

    'user_model' => [
        'path' => 'App\Models\User',
        'foreign_key' => 'id',
        'table_name' => 'users',
        'user_type_field' => 'bigInteger'
    ],

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
