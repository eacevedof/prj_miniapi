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

use TheFramework\Components\ComponentLog;

class AppController  
{
    protected $arErrors = [];
    protected $isError = FALSE;
    
    /**
     * Por convención hay que devolver un json con la clave data
     */
    protected function show_json_ok($arRows, $inData=1)
    {
        $arTmp = $arRows;
        if($inData) $arTmp = ["data" => $arRows];
        
        $sJson = json_encode($arTmp);
        $this->send_http_status(200);
        header("Content-Type: application/json");
        s($sJson);
    }
    
    protected function show_json_nok($sMessage,$iCode)
    {
        $arTmp = [
            "data" => ["mesage"=>$sMessage,"code"=>$iCode]
        ];
        
        $sJson = json_encode($arTmp);
        $this->send_http_status($iCode);
        header("Content-Type: application/json");
        s($sJson);
    }    
    
    public function send_http_status($iCode) 
    {
        $arCodes = array(
            100 => 'HTTP/1.1 100 Continue',
            101 => 'HTTP/1.1 101 Switching Protocols',
            200 => 'HTTP/1.1 200 OK',
            201 => 'HTTP/1.1 201 Created',
            202 => 'HTTP/1.1 202 Accepted',
            203 => 'HTTP/1.1 203 Non-Authoritative Information',
            204 => 'HTTP/1.1 204 No Content',
            205 => 'HTTP/1.1 205 Reset Content',
            206 => 'HTTP/1.1 206 Partial Content',
            300 => 'HTTP/1.1 300 Multiple Choices',
            301 => 'HTTP/1.1 301 Moved Permanently',
            302 => 'HTTP/1.1 302 Found',
            303 => 'HTTP/1.1 303 See Other',
            304 => 'HTTP/1.1 304 Not Modified',
            305 => 'HTTP/1.1 305 Use Proxy',
            307 => 'HTTP/1.1 307 Temporary Redirect',
            400 => 'HTTP/1.1 400 Bad Request',
            401 => 'HTTP/1.1 401 Unauthorized',
            402 => 'HTTP/1.1 402 Payment Required',
            403 => 'HTTP/1.1 403 Forbidden',
            404 => 'HTTP/1.1 404 Not Found',
            405 => 'HTTP/1.1 405 Method Not Allowed',
            406 => 'HTTP/1.1 406 Not Acceptable',
            407 => 'HTTP/1.1 407 Proxy Authentication Required',
            408 => 'HTTP/1.1 408 Request Time-out',
            409 => 'HTTP/1.1 409 Conflict',
            410 => 'HTTP/1.1 410 Gone',
            411 => 'HTTP/1.1 411 Length Required',
            412 => 'HTTP/1.1 412 Precondition Failed',
            413 => 'HTTP/1.1 413 Request Entity Too Large',
            414 => 'HTTP/1.1 414 Request-URI Too Large',
            415 => 'HTTP/1.1 415 Unsupported Media Type',
            416 => 'HTTP/1.1 416 Requested Range Not Satisfiable',
            417 => 'HTTP/1.1 417 Expectation Failed',
            500 => 'HTTP/1.1 500 Internal Server Error',
            501 => 'HTTP/1.1 501 Not Implemented',
            502 => 'HTTP/1.1 502 Bad Gateway',
            503 => 'HTTP/1.1 503 Service Unavailable',
            504 => 'HTTP/1.1 504 Gateway Time-out',
            505 => 'HTTP/1.1 505 HTTP Version Not Supported',
        );

        header($arCodes[$iCode]);
        return array("code"=>$iCode,"error"=>$arCodes[$iCode]);
    }//send_http_status
    
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
    
    public function log($mxVar,$sTitle=NULL)
    {
        if(!is_string($mxVar))
            $mxVar = var_export($mxVar,1);
        $oLog = new ComponentLog("debug",__DIR__."/../logs");
        $oLog->save($mxVar,$sTitle);
    }  
    
    private function add_error($sMessage){$this->isError = TRUE;$this->arErrors[]=$sMessage;}
    public function is_error(){return $this->isError;}
    public function get_errors($inJson=0){if($inJson) return json_encode($this->arErrors); return $this->arErrors;}
    public function get_error($i=0){isset($this->arErrors[$i])?$this->arErrors[$i]:NULL;}
    public function show_errors(){echo "<pre>".var_export($this->arErrors,1);}      
}//AppController
