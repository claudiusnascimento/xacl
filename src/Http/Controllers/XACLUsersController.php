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

    public function __construct()
    {
        $this->paginate = config('xacl.user_model.paginate', 30);
    }

    public function index(Request $request)
    {

        $users = $this->getUsers();
        $groups = Group::all();

        return view('xacl::users', compact('groups', 'users'));
    }

    /**
     * xacl Adicionar grupo nos usuários
     */
    public function addGroup(Request $request, $id)
    {
        $request->validateWithBag($request->get('_bag-' . $id, '_bag'), [
            'groups' => [
                'array',
                Rule::exists('xacl_groups', 'id')
            ]
        ],[
            'groups.array' => __('Groups in invalid format'),
            'groups.exists' => __('Inexistent group')
        ]);

        $user = $this->getUser($id);

        if(!$user) {
            \XACL::message(__('User not found'), 'danger');
            return redirect()->back();
        }

        $user->groups()->sync($request->get('groups', []));

        \XACL::message("Groups updated with success", 'success');

        return redirect()->back();
    }

    private function getUsers()
    {

        return resolve(config('xacl.user_model.path', 'App\Users'))
                ->with('groups')
                ->paginate($this->paginate);
    }

    private function getUser($id)
    {
        return resolve(config('xacl.user_model.path', 'App\Users'))->find($id);
    }
}
