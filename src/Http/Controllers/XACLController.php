<?php

namespace ClaudiusNascimento\XACL\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use ClaudiusNascimento\XACL\Support\XACLModulesCollection;
use ClaudiusNascimento\XACL\Models\XaclGroup as Group;
use XACL;

use Exception;

/**
 * @xacl Acl Controller
 */
class XACLController extends BaseController
{
    /**
     * @xacl Acl Controller Index
     */
    public function index()
    {

        // pegar todos os mudules
        $modules = new XACLModulesCollection(XACL::getXACLRoutes());

        $modules = $modules->getModules();

        return view('xacl::index', compact('modules'));
    }

    /**
     *  @xacl Acl Módulo
     */
    public function module() {

    }

    public function groups()
    {
        $groups = Group::all();

        return view('xacl::groups', compact('groups'));
    }

    /**
     * @xacl Cadastrar grupo no XACL
     */
    public function storeGroup(Request $request) {

        $request->validateWithBag('group', [
            'name' => ['required', 'unique:xacl_groups', 'max:100']
        ],[
            'name.required' => 'O nome do grupo é obrigatório',
            'name.unique' => 'Nome já existe',
            'name.max' => 'Nome pode ter no máximo 100 caracteres'
        ]);

        $request->merge([
                            'slug' => \Str::slug($request->get('name')),
                            'active' => $request->has('active')
                        ]);

        $group = Group::create($request->all());

        $request->session()->flash('xacl.alert', [
            'type' => 'success',
            'message' => 'Grupo '. $group->name .' cadastrado com sucesso'
        ]);

        return redirect()->back();
    }

}
