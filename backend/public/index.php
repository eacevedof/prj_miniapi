<?php
//index.php
include_once '../vendor/autoload.php';
include_once '../vendor/theframework/bootstrap.php';

$arRoutes = include_once '../src/Routes/routes.php';

$sRequestUri = $_SERVER["REQUEST_URI"];
$arUri = explode("?",$sRequestUri);
$sUri = $arUri[0];
$sParams = isset($arUri[1])?$arUri[1]:"";
$_POST["req_uri"] = $sUri;
$_POST["req_params"] = $sParams;

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
