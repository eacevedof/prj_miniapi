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
    
    public function __construct()
    {
        //captura trazas de la petición en los logs
        parent::__construct();
    }
    
    /**
     * ruta:    <dominio>/employees
     *          <dominio>/employees?page={n}
     * listado de empleados
     */
    public function index()
    {
        $sSearchTag = $this->get_get("s");
        $iPage = $this->get_get("page");
        if(!$iPage) $iPage=1;
        $oEmployeeSrv = new EmployeeService();
        $arResult = $oEmployeeSrv->index($iPage,$sSearchTag);
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
            return $this->show_json_nok("Employee ($id) not found",404);
        $this->show_json_ok($arRow);
    }
    
    /**
     * ruta: <dominio>/employees/insert
     */
    public function insert()
    {
        if(!$this->is_post())
            return $this->show_json_nok("Employee not created",402);
     
        $arPost = $this->get_post();
        
        $oEmployeeSrv = new EmployeeService();
        $arPost = $oEmployeeSrv->insert($arPost);
        
        if($oEmployeeSrv->is_error())
             return $this->show_json_nok($this->get_error(),402);
        
        $this->show_json_ok($arPost);
    }//insert()
    
    /**
     * ruta: <dominio>/employees/update?id={emp_no}
     */
    public function update()
    {        
        
        if(!($this->is_post() || $this->get_get("id")))
            return $this->show_json_nok("Employee not updated",402);
     
        $id = $this->get_get("id");
        $arPost = $this->get_post();
        
        $oEmployeeSrv = new EmployeeService();
        $arPost = $oEmployeeSrv->update($id,$arPost);
        
        if($oEmployeeSrv->is_error())
             return $this->show_json_nok($this->get_error(),402);
        
        $this->show_json_ok($arPost);
    }//update()
    
    /**
     * ruta: <dominio>/employees/delete?id={emp_no}
     */
    public function delete()
    {       
        if(!($this->is_post() || $this->get_get("id")))
            return $this->show_json_nok("Employee not deleted",204);
     
        $id = $this->get_get("id");
        $arPost = $this->get_post();
        
        $oEmployeeSrv = new EmployeeService();
        $arPost = $oEmployeeSrv->delete($id,$arPost);
        if($oEmployeeSrv->is_error())
             return $this->show_json_nok($this->get_error(),204);
        
        $this->show_json_ok($arPost);
    }//update()    
    
    /**
     * ruta: <dominio>/employees/test
     */    
    public function test()
    {
        $oRandom = new \App\Services\RamdomizerService();
        s($oRandom->get_string());
        pr($oRandom->get_substring_len(15));
        bug($oRandom->get_float(2,2));
        pr($oRandom->get_date_ymd());
        bug($oRandom->get_hour());
        $oEmployee = new \App\Models\EmployeeModel();
        $arGender = $oEmployee->get_gender();
        //bug($arGender,"arGender");
        $arGender = array_column($arGender,"gender");
        pr($oRandom->get_itemkey(["a"=>"A","b"=>"B","c"=>"C","d"=>"D"]));
        bug($oRandom->get_itemval($arGender));
        
    }

}//EmployeesController
