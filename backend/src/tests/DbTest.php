<?php
//Ejecución: ./vendor/bin/phpunit tests --color=auto
use PHPUnit\Framework\TestCase;

class DbTest extends TestCase
{
    public function test_exists_config_file()
    {
        $sFile = __DIR__."/../config.php";
        $isFile = is_file($sFile);
        
    }
    
    public function test_connection()
    {
        $arConfig = __DIR__."/../config.php";
        
        $oDb = new TheFramework\Components\Db();
    }
}//DbTest