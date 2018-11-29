<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Models\DeptEmpModel 
 * @file DeptEmpModel.php v1.0.0
 * @date 29-11-2018 19:00 SPAIN
 * @observations
 */
namespace App\Models;

use App\Models\AppModel;

class DeptEmpModel extends AppModel
{   
    public function __construct() 
    {
        $this->sTable = "dept_emp";
        parent::__construct();
        $this->load_fileds();
    }
    
    //hace un mapeo de los campos que vienen del formulario y los campos reales en bd
    public function load_fileds()
    {
        $arTmp = [
            ["db"=>"emp_no","ui"=>"empno"],
            ["db"=>"dept_no","ui"=>"deptno"],
            ["db"=>"from_date","ui"=>"fromdate"],
            ["db"=>"to_date","ui"=>"todate"]
        ];
        $this->arFields = $arTmp;
    }
        
}//DeptEmpModel
