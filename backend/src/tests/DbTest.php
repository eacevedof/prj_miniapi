<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/DbTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use TheFramework\Components\ComponentLog;
use TheFramework\Components\Db\ComponentMysql;

class DbTest extends TestCase
{    
    private function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("logs",__DIR__);
        $oLog->save($mxVar,$sTitle);
    }
    
    public function test_exists_config_file()
    {
        $sFile = __DIR__."/../config/config.php";
        //$this->log($sFile);
        $isFile = is_file($sFile);
        $this->assertEquals(TRUE,$isFile);
    }
    
    /**
     *  @depends test_exists_config_file
     */ 
    public function test_is_env_prod()
    {
        $sFile = __DIR__."/../config/config.php";
        $arConfig = include($sFile);
        $this->assertEquals(TRUE,is_array($arConfig));
        $this->assertEquals(FALSE,ENV=="p");
    }
    
    /**
     *  @depends test_exists_config_file
     */ 
    public function test_connection()
    {
        $sFile = __DIR__."/../config/config.php";
        $arConfig = include($sFile);
        $this->log($arConfig,"arconfig");
        $this->assertEquals(TRUE,is_array($arConfig));
        $arConfig = $arConfig["db"];
        
        $oDb = new ComponentMysql($arConfig);
        $this->assertInstanceOf(ComponentMysql::class,$oDb);
        
        $sSQL = "
        SELECT table_name 
        FROM information_schema.tables 
        where table_schema='employees'";
        
        $arRows = $oDb->query($sSQL);
        $this->log($arRows,"test_connection");
        $this->assertEquals(TRUE,count($arRows)>1);
    }
    
}//DbTest