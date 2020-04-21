<?php

namespace ClaudiusNascimento\XACL\Support;

use Illuminate\Routing\Route;
use Exception;


class XACLModulesCollection
{
    private $routesCollection;

    private $modules;

    public function __construct($routesCollection)
    {
        $this->modules = collect([]);

        $this->routesCollection = $routesCollection;

        $this->mapModules();
    }

    public function getModules()
    {
        return $this->modules;
    }

    private function mapModules() {

        $this->routesCollection->map(function($route) {
            $this->configModules($route);
        });
    }

    private function configModules($route) {

        $class = get_class($route->controller);

        $module = $this->modules->whereStrict('class', $class)->first();

        if(!$module) {

            $module = new XACLModule($class);
            $this->modules[] = $module;
        }

        $module->addMethod($route->getActionMethod());


    }

}
