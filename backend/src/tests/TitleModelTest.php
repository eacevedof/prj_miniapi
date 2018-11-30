<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/TitleModelTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;
use App\Models\TitleModel;

class TitleModelTest extends TestCase
{    
    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
    }
    
    public function test_instance()
    {
        $oModel = new App\Models\TitleModel();
        $this->assertInstanceOf(TitleModel::class,$oModel);
    }
    
    /**
     *  @depends test_instance
     */ 
    public function test_get_picklist()
    {
        $oModel = new App\Models\TitleModel();
        $arRows = $oModel->get_picklist();
        $this->log($arRows,"test_get_picklist");
        $this->assertEquals(TRUE,count($arRows)>1);
    }    
    
    /**
     *  @depends test_instance
     */ 
    public function test_has_arfields()
    {
        $oModel = new App\Models\TitleModel();
        $this->assertEquals(TRUE,property_exists($oModel,"arFields"));
    }       
}//TitleModelTest