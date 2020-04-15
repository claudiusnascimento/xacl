<?php

namespace ClaudiusNascimento\XACL\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use ClaudiusNascimento\XACL\Support\XACLModules;
use XACL;

use Exception;

class XACLController extends BaseController
{

    public function index()
    {

        // pegar todos os mudules
        $modules = new XACLModules(XACL::getXACLRoutes());

        dd($modules);

        //dd($routes->first()->getActionName());
        //dd($routes->first()->getControllerMethod());

        // $xroutes = $routes->map(function($route) {
        //     return new XRoute($route);
        // });

        //dd($xroutes->first()->getControllerMethod());

        // separá-los | cada controller é um módulo
        // pegar a anotação
        // mandar pra view com links
        //dd();
    }

}
