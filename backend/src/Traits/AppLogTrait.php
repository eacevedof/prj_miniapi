<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Traits\AppLogTrait 
 * @file AppLogTrait.php 1.0.0
 * @date 01-11-2018 19:00 SPAIN
 * @observations
 */
namespace App\Traits;

use TheFramework\Components\ComponentLog;

trait AppLogTrait 
{
    public function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("sql",__DIR__."/../logs");
        $oLog->save($mxVar,$sTitle);
    }
}//AppLogTrait
