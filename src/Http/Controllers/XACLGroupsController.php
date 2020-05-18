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
        ], $this->getValidationErrors());

        $request->merge([
                        'slug' => \Str::slug($request->get('name')),
                        'active' => $request->has('active')
                    ]);

        $group->update($request->all());

        \XACL::message(__('Group :name updated with success',[
            'name' => $group->name
        ]), 'success');

        return redirect()->back();
    }

    /**
     * @xacl ACL Cadastrar Grupo
     */
    public function store(Request $request) {

        $request->validateWithBag('group', [
            'name' => ['required', 'unique:xacl_groups', 'max:100']
        ], $this->getValidationErrors());

        $request->merge([
                            'slug' => \Str::slug($request->get('name')),
                            'active' => $request->has('active')
                        ]);

        $group = Group::create($request->all());

        \XACL::message('Group :name registered with success', [
            'name' => $group->name
        ], 'success');

        return redirect()->back();
    }

    /**
     * @xacl ACL Deletar Grupo
     */
    public function delete($id) {

        $group = Group::find($id);

        if(!$group) {

            \XACL::message('Group not found', 'info');

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

            \XACL::message('Error deleting group', 'danger');

            return redirect()->back();
        }

        DB::commit();

        \XACL::message('Group :name deleted with success', [
            'name' => $group->name
        ], 'success');

        return redirect()->back();

    }

    private function getValidationErrors() {
        return [
            'name.required' => 'Group name is required',
            'name.unique' => 'Group name already exists',
            'name.max' => 'Group name must have 100 letters in the maximum'
        ];
    }

}
