<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/EmployeeModelTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;
use App\Models\EmployeeModel;

class EmployeeModelTest extends TestCase
{    
    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
    }
    
    public function test_instance()
    {
        $oModel = new EmployeeModel();
        $this->assertInstanceOf(EmployeeModel::class,$oModel);
    }
    
    /**
     *  @depends test_instance
     */ 
    public function test_has_arfields()
    {
        $oModel = new EmployeeModel();
        $this->assertEquals(TRUE,property_exists($oModel,"arFields"));
    }  
    
    /**
     *  @depends test_instance
     */     
    public function test_new_empnos()
    {
        $oModel = new EmployeeModel();
        $iNew = $oModel->get_new_empno();
        $this->log($iNew,"test_new_empnos");
        $this->assertEquals(TRUE,$iNew>0);
    }
    
    /**
     *  @depends test_instance
     */     
    public function test_profile_nok()
    {
        $oModel = new EmployeeModel();
        $arRow = $oModel->get_profile("asbcd");
        $this->assertEquals(TRUE,count($arRow)===0);
    }    
    
    /**
     *  @depends test_instance
     */     
    public function test_profile_ok()
    {
        $oModel = new EmployeeModel();
        for($i=10001; $i<10100; $i++)
        {
            $arRow = $oModel->get_profile($i);
            $this->assertEquals(TRUE,count($arRow)>0);
        }
    }  
    
    /**
     *  @depends test_instance
     */     
    public function test_pagination_data()
    {
        $oModel = new EmployeeModel();
        $arPagination = $oModel->get_pagination();
        $this->log($arPagination,"arPagination");
        $this->assertEquals(TRUE,count($arPagination)===4);
    }

}//EmployeeModelTest