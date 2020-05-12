<?php

namespace ClaudiusNascimento\XACL\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use ClaudiusNascimento\XACL\Models\XaclGroup as Group;

use DB;

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

    }

    /**
     * @xacl ACL Cadastrar Ação
     */
    public function storeGroup(Request $request) {


    }

    /**
     * @xacl ACL Deletar Ação
     */
    public function delete($id) {


    }

}
