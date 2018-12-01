<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/InsertsTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use App\Traits\AppLogTrait;
use App\Services\RamdomizerService;
//models
use App\Models\DepartmentModel;
use App\Models\DeptEmpModel;
use App\Models\EmployeeModel;
use App\Models\SalaryModel;
use App\Models\TitleModel;

class InsertsTest extends TestCase
{    
    use AppLogTrait;
    
    private $oRnd;
    
    public function __construct() {
        parent::__construct();
        $this->oRnd = new RamdomizerService();
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
        //hace un select distinct de gender
        $arGender = $oEmployee->get_gender();
        $arGender = array_column($arGender,"gender");
        $iMax = (int)$oEmployee->get_max("emp_no");
        $iMax++;
        //emulo el post
        $arPost["empno"] = $iMax;
        $arPost["birthdate"] = $this->oRnd->get_date_ymd_from(1950);
        $arPost["firstname"] = $this->oRnd->get_substring_len(14);
        $arPost["lastname"] = $this->oRnd->get_substring_len(16);
        $arPost["gender"] = $this->oRnd->get_itemval($arGender);
        $arPost["hiredate"] = $this->oRnd->get_date_ymd_from(2000);
        
        return $arPost;
    }
    
    private function employee_insert()
    {
        $arPost = $this->get_employee_fakedata();
        $this->logd($arPost);
        $oEmployee = new EmployeeModel();
        //hago el insert del empleado
        $oEmployee->insert($arPost);
        return $oEmployee;
    }

    public function test_insert_simple_employee()
    {
        $oEmployee = $this->employee_insert();
        $this->assertEquals(FALSE,$oEmployee->is_error());
    }
    
    public function test_insert_multiple_employees()
    {
        $iNum = $this->oRnd->get_int(2,10);
        $this->logd("multiple: inum: $iNum");
        
        for($i=0;$i<$iNum;$i++)
        {
            $oEmployee = $this->employee_insert();
            $this->assertEquals(FALSE,$oEmployee->is_error());
        }
    }
      
}//InsertsTest