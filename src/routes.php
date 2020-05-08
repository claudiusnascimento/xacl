<?php

    $prefix = 'xacl.routes.prefix';
    $middle = 'xacl.routes.middlewares';

    Route::prefix(config($prefix, 'admin'))
         ->middleware(config($middle, []))
         ->namespace('ClaudiusNascimento\XACL\Http\Controllers')
         ->group(function() {

        Route::get('/xacl', 'XACLController@index')->name('xacl.index');
        Route::post('/xacl', 'XACLController@store')->name('xacl.store');

        Route::get('/xacl/groups', 'XACLGroupsController@groups')->name('xacl.groups');
        Route::post('/xacl/groups', 'XACLGroupsController@storeGroup')->name('xacl.groups.store');

    });
