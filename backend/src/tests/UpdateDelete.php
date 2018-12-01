<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/InsertsTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;
use App\Models\DepartmentModel;
use App\Models\DeptEmpModel;
use App\Models\EmployeeModel;
use App\Models\SalaryModel;
use App\Models\TitleModel;


class InsertsTest extends TestCase
{    
    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
    }
    
    private function get_random_val($arValues)
    {
        return $arValues[array_rand($arValues)];
    }
    
    public function test_multiple_inserts()
    {
        for($i=0;$i<10;$i++)
        {
            
        }
    }
      
}//InsertsTest