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
        $arRows = isset($arRows[0])?$arRows[0]:[];
        $this->show_json($arRows);        
    }
    
    // insert
    public function insert()
    {
        //si hay algo en el post
        if($this->is_post())
        {
            $arErrors = [];
            //recupero los datos del form
            $arPost = $this->get_post();
            $oEmployee = new EmployeeModel();
            $arPost["empno"] = $oEmployee->get_new_empno();
            $oEmployee->insert($arPost);
            
            if(!$oEmployee->is_error())
            {
                $arPost["fromdate"] = date("Y-m-d");
                $arPost["todate"] = "9999-01-01";
                $arPost["hiredate"] = date("Y-m-d");
                
                $oDeptEmp = new DeptEmpModel();
                $oDeptEmp->insert($arPost);
                
                $oTitle = new TitleModel();
                $oTitle->insert($arPost);
                
                $oSalary = new \App\Models\SalaryModel();
                $oSalary->insert($arPost);
                
                $this->show_json(["id"=>$arPost["empno"]]);
            }
            
            //if($oEmployee->is_error()) $arErrors[] = "employee";
        }//if(this->post)
    }//insert()

}//EmployeesController
