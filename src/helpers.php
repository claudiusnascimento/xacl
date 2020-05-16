<?php


if (! function_exists('xaclCanSee')) {

    function xaclCanSee($actions) {

        $actions_name = is_array($actions) ? $actions : func_get_args();

        $user = \Auth::user();

        if(!$user) return false;

        $user->load('groups.actions');

        if($user->groups->isNotEmpty()) {
            foreach($user->groups as $group) {

                foreach($actions_name as $action) {
                    if($group->actions->contains('action', $action)) {
                        return true;
                    }
                }

            }
        }

        return false;
    }
}

if (! function_exists('xaclCan')) {

    function xaclCan($actions) {

        return xaclCanSee($actions);
    }
}

/**
 *  PRECISA TESTAR ESSA
 */
if (! function_exists('xaclCanNotSee')) {

    function xaclCanNotSee($actions) {

        $actions_name = is_array($actions) ? $actions : func_get_args();

        $user = \Auth::user();

        if(!$user) return true;

        $user->load('groups.actions');

        if($user->groups->isNotEmpty()) {
            foreach($user->groups as $group) {

                foreach($actions_name as $action) {
                    if($group->actions->contains('action', $action)) {
                        return false;
                    }
                }

            }
        }

        return true;
    }
}

/**
 *  PRECISA TESTAR ESSA
 */
if (! function_exists('xaclCanNot')) {

    function xaclCanNot($actions) {

        return xaclCanNotSee($actions);
    }
}

