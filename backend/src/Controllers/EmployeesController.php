<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\EmployeesController 
 * @file EmployeesController.php v1.0.0
 * @date 29-11-2018 19:00 SPAIN
 * @observations
 */
namespace App\Controllers;

use App\Controllers\AppController;
use App\Models\EmployeeModel;
use App\Models\DeptEmpModel;
use \App\Models\TitleModel;

class EmployeesController extends AppController
{
    /**
     * ruta:    <dominio>/employees
     *          <dominio>/employees?page={n}
     * listado de empleados
     */
    public function index()
    {
        $iPage = $this->get_get("page");
        if(!$iPage) $iPage=1;

        $oEmpleado = new EmployeeModel();
        $oEmpleado->set_perpage(50);
        $oEmpleado->set_page($iPage);
        $arRows = $oEmpleado->get_list();
        $arPage = $oEmpleado->get_pagination();
        $this->show_json(["data"=>$arRows,"pagination"=>$arPage],0);
    }
    
    /**
     * ruta: <dominio>/employees/profile?id={emp_no}
     */
    public function profile()
    {
        $id = $this->get_get("id");
        $oEmpleado = new EmployeeModel();
        $arRows = $oEmpleado->get_profile($id);
        $arRows = isset($arRows[0])?$arRows[0]:[];
        $this->show_json($arRows);        
    }
    
    /**
     * ruta: <dominio>/employees/insert
     */
    public function insert()
    {
        //si hay algo en el post
        if($this->is_post())
        {
            //$arErrors = [];
            //recupero los datos del form
            $arPost = $this->get_post();
            $oEmployee = new EmployeeModel();
            $arPost["hiredate"] = date("Y-m-d");
            $arPost["empno"] = $oEmployee->get_new_empno();
            $oEmployee->insert($arPost);
            
            if(!$oEmployee->is_error())
            {
                $arPost["fromdate"] = date("Y-m-d");
                $arPost["todate"] = "9999-01-01";
                
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
