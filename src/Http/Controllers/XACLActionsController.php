<?php

namespace ClaudiusNascimento\XACL\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use ClaudiusNascimento\XACL\Models\XaclAction as Action;
use ClaudiusNascimento\XACL\Models\XaclGroup as Group;

use DB;
use Exception;

/**
 * @xacl ACL Controle Ações
 */
class XACLActionsController extends BaseController
{
    /**
    * @xacl ACL Listagem Ações
    */
    public function actions()
    {
        $actions = Action::with('groups')->orderBy('order', 'asc')->orderBy('action', 'asc')->get();

        $groups = Group::all();

        return view('xacl::actions', compact('actions', 'groups'));
    }

    /**
    * @xacl ACL Editar Ação
    */
    public function edit($id) {

        return view('xacl::edit-action')
            ->withGroups(Group::all())
            ->withAction(Action::with('groups')->findOrFail($id));
    }

    /**
    * @xacl ACL Atualizar Ação
    */
    public function update(Request $request, $id) {

        $action = Action::findOrFail($id);

        $request->validateWithBag('action', [
            'action' => [
                'required',
                'regex:/^[-a-zA-Z]+$/',
                Rule::unique('xacl_actions')->ignore($action),
                'max:100'
            ],
            'groups' => [
                'array',
                Rule::exists('xacl_groups', 'id')
            ]
        ],$this->getErrorMessages());

        $request->merge([
                        'active' => $request->has('active')
                    ]);

        DB::beginTransaction();

        try {

            $action->update($request->except('groups'));

            $action->groups()->sync($request->get('groups', []));

        } catch (Exception $e) {

            DB::rollback();

            \Log::info($e->getTraceAsString());
            \XACL::message(__('Error updating action'), 'danger');
            //dd($e->getMessage());
            return redirect()->back()->withInput();
        }


        DB::commit();

        \XACL::message(__('Action :name updated with success', [
            'name' => $action->action
        ]), 'success');

        return redirect()->back();
    }

    /**
     * @xacl Cadastrar Ação
     */
    public function store(Request $request) {

        $request->validateWithBag('action', [
            'action' => [
                'required',
                'regex:/^[-a-zA-Z]+$/',
                Rule::unique('xacl_actions'),
                'max:100'
            ],
            'groups' => [
                'array',
                Rule::exists('xacl_groups', 'id')
            ]
        ], $this->getErrorMessages());

        $request->merge([
                        'active' => $request->has('active')
                    ]);

        DB::beginTransaction();

        try {

            $action = Action::create($request->except('groups'));

            $action->groups()->sync($request->get('groups', []));

        } catch (Exception $e) {

            DB::rollback();
            \Log::info($e->getTraceAsString());
            \XACL::message(__('Error registering action'), 'danger');
            //dd($e->getMessage());
            return redirect()->back()->withInput();
        }

        DB::commit();

        \XACL::message(__('Action :name registered with success', [
            'name' => $action->action
        ]), 'success');

        return redirect()->back();
    }

    /**
     * @xacl ACL Deletar Ação
     */
    public function delete($id) {

        $action = Action::find($id);

        if(!$action) {

            \XACL::message('Action not found', 'info');

            return redirect()->back();
        }

        DB::beginTransaction();

        $name = $action->action;

        try {

            DB::table('xacl_action_group')->where('action_id', $id)->delete();

            $action->delete();

        } catch (Exception $e) {

            DB::rollBack();

            \Log::info('XACL::ERROR::DELETING::ACTION');
            \Log::info($e->getTraceAsString());

            \XACL::message(__('Error deleting action'), 'danger');

            return redirect()->back();
        }

        DB::commit();

        \XACL::message('Action :name deleted with success', [
            'name' => $action->action
        ], 'success');

        return redirect()->back();

    }

    private function getErrorMessages() {
        return [
            'action.required' => __('Action name is required'),
            'action.regex' => __('Use just letters and hyphens for action name'),
            'action.unique' => __('Action already exists'),
            'action.max' => __('The action must have 100 letters in the maximum'),
            'groups.array' => __('Invalid format for group'),
            'groups.exists' => __('Some group was found')
        ];
    }

}
