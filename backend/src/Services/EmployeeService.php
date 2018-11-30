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
use App\Models\SalaryModel;

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
        if(!isset($arPost["birthdate"])) 
            $arPost["birthdate"] = "2000-01-01";
        if(!isset($arPost["hiredate"])) 
            $arPost["hiredate"] = date("Y-m-d");
        if(!isset($arPost["empno"])) 
            $arPost["empno"] = $oEmployee->get_new_empno();
        
        //hago el insert del empleado
        $oEmployee->insert($arPost);

        if($oEmployee->is_error())
        {
            //escalo el error al servicio
            $this->add_error($oEmployee->get_error());
            return FALSE;
        }
          
        if(!isset($arPost["fromdate"]))$arPost["fromdate"] = $arPost["hiredate"];
        if(!isset($arPost["todate"]))$arPost["todate"] = "9999-01-01";

        //departamento de empleado
        $oDeptEmp = new DeptEmpModel();
        $oDeptEmp->insert($arPost);

        //cargo
        $oTitle = new TitleModel();
        $oTitle->insert($arPost);

        //salario
        $oSalary = new SalaryModel();
        $oSalary->insert($arPost);
        
        $this->log($arPost,"EmployeService");
        return $arPost;
    }//insert
    
    public function index($iPage)
    {
        $oEmpleado = new EmployeeModel();
        $oEmpleado->set_perpage(50);
        $oEmpleado->set_page($iPage);
        $arRows = $oEmpleado->get_list();
        $arPagination = $oEmpleado->get_pagination(); 
        return ["data"=>$arRows,"pagination"=>$arPagination];
    }//index
    
    public function profile($id)
    {
        $oEmpleado = new EmployeeModel();
        $arRow = $oEmpleado->get_profile($id);
        $arRow = isset($arRow[0])?$arRow[0]:[];
        return $arRow;
    }//
    
}//EmployeeService
