<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\AppController 
 * @file component_mysql.php v1.0.0
 * @date 19-09-2017 04:56 SPAIN
 * @observations
 */
namespace App\Controllers;

class AppController  
{
    protected function show_json($arRows)
    {
        $arTmp["data"] = $arRows; 
        $sJson = json_encode($arTmp);
        header("Content-Type: application/json");
        s($sJson);
    }
    
    protected function get_post($sKey=NULL)
    {
        if(!$sKey) return $_POST;
        return (isset($_POST[$sKey])?$_POST[$sKey]:"");
    }
    
    protected function is_post(){return count($_POST)>0;}
    
}//AppController
