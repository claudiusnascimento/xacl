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
        Route::post('/xacl/groups/{id}/delete', 'XACLGroupsController@delete')->name('xacl.groups.delete');

        Route::get('/xacl/actions', 'XACLActionsController@actions')->name('xacl.actions');
        Route::post('/xacl/actions', 'XACLActionsController@store')->name('xacl.actions.store');
        Route::post('/xacl/actions/{id}/delete', 'XACLActionsController@delete')->name('xacl.actions.delete');

    });
