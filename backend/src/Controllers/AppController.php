<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\AppController 
 * @file AppController.php v1.0.0
 * @date 29-11-2018 19:00 SPAIN
 * @observations
 */
namespace App\Controllers;

class AppController  
{
    /**
     * Por convención hay que devolver un json con la clave data
     */
    protected function show_json($arRows, $inData=1)
    {
        $arTmp = $arRows;
        if($inData)
            $arTmp["data"] = $arRows;
        
        $sJson = json_encode($arTmp);
        header("Content-Type: application/json");
        s($sJson);
    }
    
    /**
     * lee valores de $_POST
     */
    protected function get_post($sKey=NULL)
    {
        if(!$sKey) return $_POST;
        return (isset($_POST[$sKey])?$_POST[$sKey]:"");
    }
    
    protected function is_post(){return count($_POST)>0;}

    /**
     * lee valores de $_GET
     */
    protected function get_get($sKey=NULL)
    {
        if(!$sKey) return $_GET;
        return (isset($_GET[$sKey])?$_GET[$sKey]:"");
    }
    
    protected function is_get(){return count($_GET)>0;}    
    
}//AppController
