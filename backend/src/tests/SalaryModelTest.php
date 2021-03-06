<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/SalaryModelTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;
use App\Models\SalaryModel;

class SalaryModelTest extends TestCase
{    
    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
    }
    
    public function test_instance()
    {
        $oModel = new App\Models\SalaryModel();
        $this->assertInstanceOf(SalaryModel::class,$oModel);
    }
    
    /**
     *  @depends test_instance
     */ 
    public function test_get_picklist()
    {
        $oModel = new App\Models\SalaryModel();
        $arRows = $oModel->get_picklist();
        $this->log($arRows,"test_get_picklist");
        $this->assertEquals(TRUE,count($arRows)>1);
    }    
    
    /**
     *  @depends test_instance
     */ 
    public function test_has_arfields()
    {
        $oModel = new App\Models\SalaryModel();
        $this->assertEquals(TRUE,property_exists($oModel,"arFields"));
    }       
}//SalaryModelTest