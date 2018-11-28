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

use App\Controllers\AppController;

class NotFoundController extends AppController
{
    public function index()
    {
        $sPath = realpath(__DIR__."/../routes/routes.php");
        $arRutas = include $sPath;
        s("<pre>");
        foreach($arRutas as $arRuta)
        {
            s("<a href=\"{$arRuta["url"]}\" target=\"_blank\">{$arRuta["url"]}</a><br/>");
        }
    }

    public function error_404()
    {
        $this->show_json(["message"=>"404 resource not found!"]);
    }    

}//NotFoundController
