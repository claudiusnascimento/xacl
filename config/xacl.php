<?php

return [

    // if theres no groups the package use this e-mail to given total permission
    'start_email' => 'cau@claudiusnascimento.com',

    'routes' => [
        // prefix to package use with the routes
        'prefix' => 'admin',

        // middlewares to use with the packages routes
        'middlewares' => ['web', 'auth', 'xacl']
    ],

    /**
     *  user model config
     */
    'user_model' => [
        'path' => 'App\Models\User',
        'foreign_key' => 'id',
        'table_name' => 'users',
        'email_field_name' => 'email',

        // need this information to run migrations properly
        'user_type_field' => 'bigInteger',

        // paginate users called in view to sync the groups
        'paginate' => 100
    ],

    /**
     *  used is case you dont use the docs methods
     */
    'docs_defaults' => [

        '__construct' => 'Home',
        'aindex' => 'Index',
        'create' => 'Create',
        'store' => 'Save',
        'show' => 'See',
        'edit' => 'See/Edit',
        'update' => 'Save Editing',
        'destroy' => 'Delete'
    ],

    /**
     *  start pattern to take routes descriptions
     */
    'doc_start_pattern' => '@xacl',

    /**
     *  template and sectio to use with the package views
     */
    'view' => [
        'extends' => 'gentelelladashboard::layouts.main',
        'section' => 'content'
    ],

    /**
     *  config the blade tags if you wish
     */
    'blade' => [
        'can_open_tag' => 'xaclCanSee',
        'can_close_tag' => 'endXaclCanSee',
        'can_not_open_tag' => 'xaclCanNotSee',
        'can_not_close_tag' => 'endXaclCanNotSee'
    ],

    /**
     *  code uses the default route if this value is empty
     */
    'no-permission-route-name' => ''

];
