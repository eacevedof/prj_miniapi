<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\AppService 
 * @file AppService.php 1.0.0
 * @date 29-11-2018 19:00 SPAIN
 * @observations
 */
namespace App\Services;

use TheFramework\Components\ComponentLog;

class AppService 
{
    protected $arErrors = [];
    protected $isError = FALSE;
    
    public function __construct() 
    {
        ;
    }
        
    protected function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("sql",__DIR__."/../logs");
        $oLog->save($mxVar,$sTitle);
    }
    
    private function add_error($sMessage){$this->isError = TRUE;$this->arErrors[]=$sMessage;}
    public function is_error(){return $this->isError;}
    public function get_errors($inJson=0){if($inJson) return json_encode($this->arErrors); return $this->arErrors;}
    public function get_error($i=0){isset($this->arErrors[$i])?$this->arErrors[$i]:NULL;}
    public function show_errors(){echo "<pre>".var_export($this->arErrors,1);}    
}//AppService
