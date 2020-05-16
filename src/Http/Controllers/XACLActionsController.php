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
        ],[
            'action.required' => 'A ação é obrigatória',
            'action.regex' => 'Ação só é permitido letras e hífens',
            'action.unique' => 'Ação já existe',
            'action.max' => 'Ação pode ter no máximo 100 caracteres',
            'groups.array' => 'Grupos em formato inválido',
            'groups.exists' => 'Algum grupo não foi encontrado'
        ]);

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
            \XACL::message('Erro ao atualizar ação', 'danger');
            //dd($e->getMessage());
            return redirect()->back()->withInput();
        }


        DB::commit();

        \XACL::message('Ação '. $action->action .' atualizada com sucesso', 'success');

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
        ],[
            'action.required' => 'A ação é obrigatória',
            'action.regex' => 'Ação só é permitido letras e hífens',
            'action.unique' => 'Ação já existe',
            'action.max' => 'Ação pode ter no máximo 100 caracteres',
            'groups.array' => 'Grupos em formato inválido',
            'groups.exists' => 'Algum grupo não foi encontrado'
        ]);

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
            \XACL::message('Erro ao cadastrar ação', 'danger');
            //dd($e->getMessage());
            return redirect()->back()->withInput();
        }

        DB::commit();

        \XACL::message('Ação '. $action->name .' cadastrada com sucesso', 'success');

        return redirect()->back();
    }

    /**
     * @xacl ACL Deletar Ação
     */
    public function delete($id) {

        $action = Action::find($id);

        if(!$action) {

            \XACL::message('Ação não encontrada', 'info');

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

            \XACL::message('Erro ao deletar ação', 'danger');

            return redirect()->back();
        }

        DB::commit();

        \XACL::message('Ação '. $name .' deletada com sucesso', 'success');

        return redirect()->back();

    }

}
