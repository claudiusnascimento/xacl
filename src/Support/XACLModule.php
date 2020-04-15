<?php

namespace ClaudiusNascimento\XACL\Support;

use Illuminate\Routing\Route;

class XACLRouteModules
{
    private $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }

}
