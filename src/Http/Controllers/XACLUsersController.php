<?php

namespace ClaudiusNascimento\XACL\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use ClaudiusNascimento\XACL\Models\XaclGroup as Group;

use DB;

/**
 * @xacl ACL Controle de Usuários
 */
class XACLUsersController extends BaseController
{

    private $paginate;

    public function __construct() {
        $this->paginate = config('xacl.user_model.paginate', 30);
    }

    public function index(Request $request) {

        $users = $this->getUsers();
        $groups = Group::all();

        return view('xacl::users', compact('groups', 'users'));
    }

    private function getUsers() {

        return resolve(config('xacl.user_model.path', 'App\Users'))
                ->with('groups')
                ->paginate($this->paginate);
    }
}
