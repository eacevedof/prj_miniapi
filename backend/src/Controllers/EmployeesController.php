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
use App\Services\EmployeeService;

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
        $this->show_json_ok(["data"=>$arRows,"pagination"=>$arPage] ,0);
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
        $this->show_json_ok($arRows);        
    }
    
    /**
     * ruta: <dominio>/employees/insert
     */
    public function insert()
    {
        $this->log($this->get_post(),"post en insert");
        
        if(!$this->is_post())
            return $this->show_json_nok("Error saving employee",204);
     
        $arPost = $this->get_post();
        $oEmployeeSrv = new EmployeeService();
        $arPost = $oEmployeeSrv->insert($arPost);
        if($oEmployeeSrv->is_error())
             return $this->show_json_nok($this->get_error(),204);
        $this->show_json_ok($arPost);

    }//insert()

}//EmployeesController
