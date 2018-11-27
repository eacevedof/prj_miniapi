<?php
//index.php
define("DS",DIRECTORY_SEPARATOR);
define("TFW_DOCROOT",$_SERVER["DOCUMENT_ROOT"]);
define("TFW_DOCROOTDS",TFW_DOCROOT.DS);

include_once '../vendor/autoload.php';
include_once '../vendor/theframework/bootstrap.php';

$arRoutes = include_once '../src/Routes/routes.php';

$sRequestUri = $_SERVER["REQUEST_URI"];
$arUri = explode("?",$sRequestUri);
$sUri = $arUri[0];
$sParams = isset($arUri[1])?$arUri[1]:"";

/* No hace falta, llega por Get
 * 
$_POST["req_uri"] = $sUri;
$arParams = explode("&",$sParams);
$arReqParams = [];
foreach($arParams as $sParEqual)
{
    $arTmp = explode("=",$sParEqual);
    $arReqParams[$arTmp[0]] = isset($arTmp[1])?$arTmp[1]:"";
}
$_POST["req_params"] = $arReqParams;
* 
*/
bugpg();
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
