<?php

namespace ClaudiusNascimento\XACL\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use ClaudiusNascimento\XACL\Support\XACLModulesCollection;
use ClaudiusNascimento\XACL\Models\XaclGroup as Group;
use ClaudiusNascimento\XACL\Models\XaclModule as Module;

use XACL;

use DB;

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

        $groups = Group::all();

        return view('xacl::index', compact('modules', 'groups'));
    }

    /**
     * @xacl Acl Controller Salvar
     */
    public function store(Request $request)
    {

        DB::beginTransaction();

        $saved = false;

        try {

            Group::query()->delete();
            Module::query()->delete();
            DB::table('xacl_group_module')->delete();

            foreach($request->get('permissions', []) as $permission) {

                $arr_permission = $this->getObj($permission);

                if(is_array($arr_permission)) {
                    $module = Module::firstOrCreate(['controller_action' => $arr_permission['module']]);
                    $module->groups()->sync([$arr_permission['group_id']]);

                    $saved = true;
                }
            }

        } catch (Exception $e) {
            DB::rollBack();

            $request->session()->flash('xacl.alert', [
                'type' => 'danger',
                'message' => 'Erro ao salvar as permissões'
            ]);

            \Log::info($e->getMessage());

            return redirect()->back();
        }

        // at least 1 was saved
        if($saved) {
            DB::commit();
        } else {
            DB::rollBack();
        }


        $request->session()->flash('xacl.alert', [
            'type' => $saved ? 'success' : 'info',
            'message' => $saved ? 'Permissões setadas com sucesso' : 'Nenhuma permissão salva'
        ]);

        return redirect()->back();
    }

    private function getObj($permission) {

        $pattern = '/^gid\|(\d+)\|([\\\\a-zA-Z0-9_]+@[\\\\a-zA-Z0-9_]+)$/';

        if(preg_match($pattern, $permission, $match)) {
            return [
                'group_id' => $match[1],
                'module' => $match[2]
            ];
        }

        return false;
    }

}
