<?php

namespace ClaudiusNascimento\XACL\Support;

use Illuminate\Routing\Route;

class XACLRouteModules
{
    private $routes;

    private $modules = [];

    public function __construct($routes)
    {
        $this->routes = $routes;

        $this->modules = collect([]);
    }

    public function setModules()
    {
        $this->routes->map(function($route) {

            $module = new XACLModule($route);
            $module->config();


        });
    }

}
