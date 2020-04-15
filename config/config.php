<?php

return [

    'routes' => [
        'prefix' => 'admin',
        'middlewares' => ['web', 'auth', 'xacl']
    ],

    'user_model_path' => '\App\Models\User'

];
