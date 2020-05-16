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



    public static function hasPermission($request) {


        $user = \Auth::user();

        $user->load(['groups' => function($query) {
            $query->with('modules');
            $query->with('actions');
        }]);

        $controller_action = $request->route()->getActionName();

        if($user->groups->isNotEmpty()) {

            $groups = $user->groups;

            foreach($groups as $group) {
                if($group->modules->contains('controller_action', $controller_action)) {
                    return true;
                }
            }
        }

        if(!\ClaudiusNascimento\XACL\Models\XaclGroup::get()->count()) {
            $email = $user->{config('xacl.start_email', '')};

            if($user->{config('xacl.user_model.email_field_name')} === config('xacl.start_email')) {
                return true;
            }
        }

        return false;
    }

    public static function getRedirectRoute() {

        return config('no-permission-route-name', 'xacl.no.permission');
    }
}
