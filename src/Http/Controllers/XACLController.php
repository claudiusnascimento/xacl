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
        // dd(Module::with('groups')->get());
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

        $groupsCollection = Group::select('id')->pluck('id');

        DB::beginTransaction();

        $saved = false;
        $count = 0;

        try {

            //Group::query()->delete();
            DB::table('xacl_group_module')->delete();
            Module::query()->delete();

            $permissions = $request->get('permissions', []);
            $countPermissions = count($permissions);

            $stored = [];

            foreach($permissions as $permission) {

                $arr_permission = $this->getGroupIdAndModule($permission);

                if(is_array($arr_permission)) {

                    $group_id = $arr_permission['group_id'];
                    $module = $arr_permission['module'];

                    // module exists?
                    if(!$groupsCollection->contains($group_id)) {
                        continue;
                    }

                    // already stored?
                    if(in_array($permission, $stored)) {
                        continue;
                    }

                    $module = Module::firstOrCreate(['controller_action' => $module]);

                    if($module) {
                        $module->groups()->attach([$group_id]);
                        $saved = true;
                        $count++;

                        $stored[] = $permission;
                    }

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
        if($saved && $count == $countPermissions) {
            DB::commit();

            $type = 'success';
            $message = 'Permissões setadas com sucesso';
        } else {
            DB::rollBack();

            \Log::info('$saved');
            \Log::info($saved);
            \Log::info('Count e CountPermissions');
            \Log::info($count . ' - ' . $countPermissions);

            $type = 'info';
            $message = 'Nenhuma permissão salva';
        }


        $request->session()->flash('xacl.alert', [
            'type' => $saved ? 'success' : 'info',
            'message' => $saved ? 'Permissões setadas com sucesso' : 'Nenhuma permissão salva'
        ]);

        return redirect()->back();
    }

    private function getGroupIdAndModule($permission) {

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
