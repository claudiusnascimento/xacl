<?php

namespace ClaudiusNascimento\XACL\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use ClaudiusNascimento\XACL\Models\XaclGroup as Group;

use DB;

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

    public function edit($id) {

        return view('xacl::edit-group')->withGroup(Group::findOrFail($id));
    }

    public function update(Request $request, $id) {

        $group = Group::findOrFail($id);

        $request->validateWithBag('group', [
            'name' => [
                'required',
                Rule::unique('xacl_groups')->ignore($group),
                'max:100'
            ]
        ],[
            'name.required' => 'O nome do grupo é obrigatório',
            'name.unique' => 'Nome já existe',
            'name.max' => 'Nome pode ter no máximo 100 caracteres'
        ]);

        $request->merge([
                        'slug' => \Str::slug($request->get('name')),
                        'active' => $request->has('active')
                    ]);

        $group->update($request->all());

        \XACL::message('Grupo '. $group->name .' atualizado com sucesso', 'success');

        return redirect()->back();
    }

    /**
     * @xacl ACL Cadastrar Grupo
     */
    public function store(Request $request) {

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

        \XACL::message('Grupo '. $group->name .' cadastrado com sucesso', 'success');

        return redirect()->back();
    }

    /**
     * @xacl ACL Deletar Grupo
     */
    public function delete($id) {

        $group = Group::find($id);

        if(!$group) {

            \XACL::message('Grupo não encontrado', 'info');

            return redirect()->back();
        }

        DB::beginTransaction();

        $name = $group->name;

        try {

            DB::table('xacl_group_module')->where('group_id', $id)->delete();

            $group->delete();

        } catch (\Exception $e) {

            DB::rollBack();

            \Log::info('XACL::ERROR::DELETING::GROUP');
            \Log::info($e->getTraceAsString());

            \XACL::message('Erro ao deletar grupo', 'danger');

            return redirect()->back();
        }

        DB::commit();

        \XACL::message('Grupo '. $name .' deletado com sucesso', 'success');

        return redirect()->back();

    }

}
