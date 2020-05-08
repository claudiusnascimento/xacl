<?php

namespace ClaudiusNascimento\XACL\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use ClaudiusNascimento\XACL\Models\XaclGroup as Group;

/**
 * @xacl ACL Controle de Grupos
 */
class XACLGroupsController extends BaseController
{
    /**
    * @xacl ACL Listagem Grupos
    */
    public function groups()
    {
        $groups = Group::orderBy('order', 'asc')->orderBy('name', 'asc')->get();

        return view('xacl::groups', compact('groups'));
    }

    /**
     * @xacl ACL Cadastrar Grupo
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
