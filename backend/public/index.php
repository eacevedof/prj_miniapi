<?php
//index.php

//https://stackoverflow.com/questions/14467673/enable-cors-in-htaccess
// Allow from any origin
if(isset($_SERVER["HTTP_ORIGIN"])) 
{
    // should do a check here to match $_SERVER["HTTP_ORIGIN"] to a
    // whitelist of safe domains
    header("Access-Control-Allow-Origin: {$_SERVER["HTTP_ORIGIN"]}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if($_SERVER["REQUEST_METHOD"] == 'OPTIONS'){

    if(isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         

    if(isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
        header("Access-Control-Allow-Headers: {$_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]}");
}

define("DS",DIRECTORY_SEPARATOR);
define("TFW_DOCROOT",$_SERVER["DOCUMENT_ROOT"]);
define("TFW_DOCROOTDS",TFW_DOCROOT.DS);

include_once '../vendor/autoload.php';
include_once '../vendor/theframework/bootstrap.php';

$arRoutes = include_once '../src/routes/routes.php';
$sRequestUri = $_SERVER["REQUEST_URI"];
$arUri = explode("?",$sRequestUri);
$sUri = $arUri[0];


//llamada y ejecución del controlador
$arRun = [];
//busco la url 
foreach($arRoutes as $arRoute)
{
    if($arRoute["url"]==$sUri)
    {
        //se encuntra 
        $arRun = $arRoute;
        break;
    }
}

//el 404
if(!$arRun) $arRun = $arRoute;
    
$oController = new $arRun["controller"]();
$oController->{$arRun["method"]}();
