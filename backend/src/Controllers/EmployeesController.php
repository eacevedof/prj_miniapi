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
use App\Models\DeptEmpModel;
use \App\Models\TitleModel;

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
        //si hay algo en el post
        /*
ay(1) {
  ["POST"]=>
  array(7) {
    ["firstname"]=>
    ["lastname"]=>
    ["birthdate"]=>
    ["gender"]=>
         * 
    ["deptno"]=>
         * 
    ["utitle"]=>
    ["salary"]=>
  }
}
         *          */
        if($this->is_post())
        {
            $arErrors = [];
            $arPost = $this->get_post();
            $oEmployee = new EmployeeModel();
            $oEmployee->insert($arPost);
            
            if(!$oEmployee->is_error())
            {
                $arPost["emp_no"] = $oEmployee->get_lastinsert_id();
                $arPost["fromdate"] = date("Y-m-d");
                $arPost["todate"] = "2100-01-01";
                
                $oDeptEmp = new DeptEmpModel();
                $oDeptEmp->insert($arPost);
                
                $oTitle = new TitleModel();
                $oTitle->insert($arPost);
                
            }
            
            if($oEmployee->is_error()) $arErrors[] = "employee";
            
        }
            
    }

    private function before_insert()
    {

    }

}//EmployeesController
