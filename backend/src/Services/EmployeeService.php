<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\EmployeeService 
 * @file EmployeeService.php 1.0.0
 * @date 29-11-2018 19:00 SPAIN
 * @observations
 */
namespace App\Services;

use App\Services\AppService;
use App\Models\DeptEmpModel;
use App\Models\TitleModel;
use App\Models\EmployeeModel;

class EmployeeService extends AppService
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function insert($arPost)
    {
        //TODO: Habria que hacer un middleware antes de procesar el post
        //TODO: Tendría que probar validación de tipos, campos requeridos y longitudes antes de procesar el insert
        //recupero los datos del form
        $oEmployee = new EmployeeModel();
        if(!isset($arPost["hiredate"]))$arPost["hiredate"] = date("Y-m-d");
        if(!isset($arPost["empno"])) $arPost["empno"] = $oEmployee->get_new_empno();
        $oEmployee->insert($arPost);

        if(!$oEmployee->is_error())
        {
            if(!isset($arPost["fromdate"]))$arPost["fromdate"] = $arPost["hiredate"];
            if(!isset($arPost["todate"]))$arPost["todate"] = "9999-01-01";

            $oDeptEmp = new DeptEmpModel();
            $oDeptEmp->insert($arPost);

            $oTitle = new TitleModel();
            $oTitle->insert($arPost);

            $oSalary = new \App\Models\SalaryModel();
            $oSalary->insert($arPost);

            $this->log($arPost,"post2 en insert");
            return $arPost;
        } 
        return FALSE;
    }//insert
    
}//EmployeeService
