<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\EmployeesController 
 * @file EmployeesController.php 2.0.0
 * @date 30-11-2018 19:00 SPAIN
 * @observations
 */
namespace App\Controllers;

use App\Controllers\AppController;
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
        $oEmployeeSrv = new EmployeeService();
        $arResult = $oEmployeeSrv->index($iPage);
        $this->show_json_ok($arResult,0);
    }//index
    
    /**
     * ruta: <dominio>/employees/profile?id={emp_no}
     */
    public function profile()
    {
        $id = $this->get_get("id");
        $oEmployeeSrv = new EmployeeService();
        $arRow = $oEmployeeSrv->profile($id);
        if(!$arRow)
            return $this->show_json_nok("Employee ($id) not found",200);
        $this->show_json_ok($arRow);
    }
    
    /**
     * ruta: <dominio>/employees/insert
     */
    public function insert()
    {
        $this->log($this->get_post(),"post en insert");
        
        if(!$this->is_post())
            return $this->show_json_nok("Employee not created",204);
     
        $arPost = $this->get_post();
        $oEmployeeSrv = new EmployeeService();
        $arPost = $oEmployeeSrv->insert($arPost);
        if($oEmployeeSrv->is_error())
             return $this->show_json_nok($this->get_error(),204);
        $this->show_json_ok($arPost);
    }//insert()
    
    /**
     * ruta: <dominio>/employees/update?id={emp_no}
     */
    public function update()
    {
        //traza del post
        $this->log($this->get_post(),"post en insert");
        
        if(!$this->is_post())
            return $this->show_json_nok("Employee not updated",204);
     
        $arPost = $this->get_post();
        $oEmployeeSrv = new EmployeeService();
        $arPost = $oEmployeeSrv->update($id,$arPost);
        if($oEmployeeSrv->is_error())
             return $this->show_json_nok($this->get_error(),204);
        $this->show_json_ok($arPost);
    }//update()
    

}//EmployeesController
