<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/InsertsTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;

use App\Services\RamdomizerService;
use App\Models\DepartmentModel;
use App\Models\DeptEmpModel;
use App\Models\EmployeeModel;
use App\Models\SalaryModel;
use App\Models\TitleModel;


class InsertsTest extends TestCase
{    
    private $oRnd;
    
    public function __construct() {
        parent::__construct();
        $this->oRnd = new RamdomizerService();
    }
    
    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
    }
    
    private function get_employee_fakedata()
    {
/*
+-----------+------------+------+-----------+----------+
| tablename | fieldname  | ispk | fieldtype | fieldlen |
+-----------+------------+------+-----------+----------+
| employees | emp_no     | Y    | int       | \N       |
| employees | birth_date |      | date      | \N       |
| employees | first_name |      | varchar   | 14       |
| employees | last_name  |      | varchar   | 16       |
| employees | gender     |      | enum      | 1        |
| employees | hire_date  |      | date      | \N       |
+-----------+------------+------+-----------+----------+
*/
        $oEmployee = new EmployeeModel();
        $arGender = $oEmployee->get_gender();
        $iMax = (int) $oEmployee->get_max("emp_no");
        //emulo el post
        $arPost["empno"] = ($iMax++);
        $arPost["birthdate"] = $this->oRnd->get_date_ymd();
        $arPost["firstname"] = $this->oRnd->get_date_ymd();
        $arPost["lastname"] = $this->oRnd->get_date_ymd();
        
        $arPost["gender"] = $this->oRnd->get_itemkey($arGender);
        $arPost["hiredate"] = $this->oRnd->get_date_ymd();
    }
    
    public function insert_simple_employee()
    {
        $oEmployee = new EmployeeModel();
        if(!isset($arPost["birthdate"])) 
            $arPost["birthdate"] = "2000-01-01";
        if(!isset($arPost["hiredate"])) 
            $arPost["hiredate"] = date("Y-m-d");
        if(!isset($arPost["empno"])) 
            $arPost["empno"] = $oEmployee->get_new_empno();
        
        //hago el insert del empleado
        $oEmployee->insert($arPost);        
    }
    
    public function test_multiple_inserts()
    {
        for($i=0;$i<10;$i++)
        {
            
        }
    }
      
}//InsertsTest