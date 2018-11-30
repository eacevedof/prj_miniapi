<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/DeptEmpModelTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;
use App\Models\DeptEmpModel;

class DeptEmpModelTest extends TestCase
{    
    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
    }
    
    public function test_instance()
    {
        $oModel = new App\Models\DeptEmpModel();
        $this->assertInstanceOf(DeptEmpModel::class,$oModel);
    }
    
    /**
     *  @depends test_instance
     */ 
    public function test_has_arfields()
    {
        $oModel = new App\Models\DeptEmpModel();
        $this->assertEquals(TRUE,property_exists($oModel,"arFields"));
    }    
    
}//DeptEmpModelTest