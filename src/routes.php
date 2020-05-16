<?php

    $prefix = 'xacl.routes.prefix';
    $middle = 'xacl.routes.middlewares';

    Route::prefix(config($prefix, 'admin'))
         ->namespace('ClaudiusNascimento\XACL\Http\Controllers')
         ->group(function() use ($middle) {


        Route::middleware(config($middle, []))->group(function() {

            Route::get('/xacl', 'XACLController@index')->name('xacl.index');
            Route::post('/xacl', 'XACLController@store')->name('xacl.store');

            Route::get('/xacl/groups', 'XACLGroupsController@groups')->name('xacl.groups');
            Route::post('/xacl/groups', 'XACLGroupsController@store')->name('xacl.groups.store');
            Route::get('/xacl/groups/{id}/edit', 'XACLGroupsController@edit')->name('xacl.groups.edit');
            Route::post('/xacl/groups/{id}/update', 'XACLGroupsController@update')->name('xacl.groups.update');
            Route::post('/xacl/groups/{id}/delete', 'XACLGroupsController@delete')->name('xacl.groups.delete');

            Route::get('/xacl/actions', 'XACLActionsController@actions')->name('xacl.actions');
            Route::post('/xacl/actions', 'XACLActionsController@store')->name('xacl.actions.store');
            Route::get('/xacl/actions/{id}/edit', 'XACLActionsController@edit')->name('xacl.actions.edit');
            Route::post('/xacl/actions/{id}/update', 'XACLActionsController@update')->name('xacl.actions.update');
            Route::post('/xacl/actions/{id}/delete', 'XACLActionsController@delete')->name('xacl.actions.delete');

            Route::get('/xacl/users', 'XACLUsersController@index')->name('xacl.users');
            Route::post('/xacl/users/{id}/add/group', 'XACLUsersController@addGroup')->name('xacl.users.add.group');

        });


        if(config('xacl.no-permission-route-name', '') === '') {

            $middle_xacl_removed = array_filter(config($middle, []), function($item) {
                return $item !== 'xacl';
            });

            Route::get('/xacl/no/permission', function() {
                return view('xacl::no-permission');
            })->middleware($middle_xacl_removed)->name('xacl.no.permission');

        }


    });


