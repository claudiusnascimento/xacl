<?php

namespace ClaudiusNascimento\XACL;
use Illuminate\Support\Facades\Route;

class XACL
{
    /**
     *  Return all routes with the xacl middleware
     */
    public function getXACLRoutes()
    {
        return collect($this->getAllRoutes())->filter(function($route) {
            return in_array('xacl', $route->gatherMiddleware());
        });
    }

    /**
     *  Return all app routes
     */
    protected function getAllRoutes() {

        return Route::getRoutes()->get();
    }
}
