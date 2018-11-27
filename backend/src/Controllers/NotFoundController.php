<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\NotFoundController 
 * @file component_mysql.php v1.0.0
 * @date 19-09-2017 04:56 SPAIN
 * @observations
 */
namespace App\Controllers;

class NotFoundController
{
    public function index()
    {
        $arData = ["data"=>["mensaje"=>"404 resource not found!"]];
        $sJson = json_encode($arData);
        s($sJson);
    }

}//NotFoundController
