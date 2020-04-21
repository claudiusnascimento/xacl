<?php

    $prefix = 'xacl.routes.prefix';
    $middle = 'xacl.routes.middlewares';

    Route::
        prefix(config($prefix, 'admin'))
        ->middleware(config($middle, []))
        ->namespace('ClaudiusNascimento\XACL\Http\Controllers')
            ->group(function() {


        Route::get('/xacl', 'XACLController@index')->name('xacl.index');
        Route::get('/xacl/groups', 'XACLController@groups')->name('xacl.groups');
        Route::post('/xacl/groups', 'XACLController@storeGroup')->name('xacl.groups.store');

    });
