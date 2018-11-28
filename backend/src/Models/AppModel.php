<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Models\AppModel 
 * @observations
 */
namespace App\Models;

use TheFramework\Components\Db\ComponentMysql;

class AppModel 
{
    protected $oDb;
    
    public function __construct() 
    {
        $arConfig = $this->get_config("db");
        $oDb = new ComponentMysql();
        $oDb->add_conn("server",$arConfig["server"]);
        $oDb->add_conn("database",$arConfig["database"]);
        $oDb->add_conn("user",$arConfig["user"]);
        $oDb->add_conn("password",$arConfig["password"]);
        $this->oDb = $oDb;
    }
    
    protected function get_config($sKey)
    {
        $arConfig = realpath(__DIR__."/../config/config.php");
        $arConfig = include($arConfig);
        return $arConfig[$sKey];        
    }
        
    
}//AppModel
