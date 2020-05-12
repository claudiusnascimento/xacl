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

    public static function getInputvalue($group, $module, $method) {
        return 'gid|' . $group->id . '|' . $module->class . '@' . $method;
    }

    public static function getChecked($group, $module, $method) {

        return $group->modules->contains('controller_action', $module->class . '@' . $method) ?
        ' checked' : '';
    }

    public static function message($message, $type = 'success') {
        session()->flash('xacl.alert', [
            'type' => $type,
            'message' => $message
        ]);
    }
}
