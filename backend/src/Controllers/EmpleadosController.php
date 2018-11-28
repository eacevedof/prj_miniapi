<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\EmpleadosController 
 * @file component_mysql.php v1.0.0
 * @date 19-09-2017 04:56 SPAIN
 * @observations
 */
namespace App\Controllers;

use App\Models\EmpleadoModel;

class EmpleadosController 
{
    // listado
    public function index()
    {
        $oEmpleado = new EmpleadoModel();
        $arRows = $oEmpleado->get_list();
        $this->show_json($arRows);
    }
    
    // detalle / ficha del empleado
    public function profile()
    {
        $id = isset($_GET["id"])?$_GET["id"]:NULL;
        $oEmpleado = new EmpleadoModel();
        $arRows = $oEmpleado->get_profile($id);
        $this->show_json($arRows);        
    }
    
    // insert
    public function insert()
    {
        $arData = $_POST[""];
        $oEmpleado = new EmpleadoModel();
        $isOk = $oEmpleado->insert($arData);
        if(!$isOk)
            $this->show_json(["message"=>"503 Error"]);
    }

    private function show_json($arRows)
    {
        $arTmp["data"] = $arRows; 
        $sJson = json_encode($arTmp);
        s($sJson);
    }
}//EmpleadosController
