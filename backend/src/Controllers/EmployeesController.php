<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\EmployeesController 
 * @file component_mysql.php v1.0.0
 * @date 19-09-2017 04:56 SPAIN
 * @observations
 */
namespace App\Controllers;

use App\Controllers\AppController;
use App\Models\EmployeeModel;

class EmployeesController extends AppController
{
    // listado
    public function index()
    {
        $oEmpleado = new EmployeeModel();
        $arRows = $oEmpleado->get_list();
        $this->show_json($arRows);
    }
    
    // detalle / ficha del empleado
    public function profile()
    {
        $id = isset($_GET["id"])?$_GET["id"]:NULL;
        $oEmpleado = new EmployeeModel();
        $arRows = $oEmpleado->get_profile($id);
        $this->show_json($arRows);        
    }
    
    // insert
    public function insert()
    {
        $arData = $this->get_post("");
        $isOk = FALSE;
        if($arData)
        {
            $oEmpleado = new EmployeeModel();
            $isOk = $oEmpleado->insert($arData);
        }
        if(!$isOk)
            $this->show_json(["message"=>"503 Error on insert"]);
    }


}//EmployeesController
