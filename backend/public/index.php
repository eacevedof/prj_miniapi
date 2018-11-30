<?php
//index.php 1.0.0

//Código de configuración de cabeceras que permiten consumir la API desde cualquier origen
//fuente: https://stackoverflow.com/questions/14467673/enable-cors-in-htaccess
// Allow from any origin
if(isset($_SERVER["HTTP_ORIGIN"])) 
{
    //should do a check here to match $_SERVER["HTTP_ORIGIN"] to a
    //whitelist of safe domains
    header("Access-Control-Allow-Origin: {$_SERVER["HTTP_ORIGIN"]}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if($_SERVER["REQUEST_METHOD"] == 'OPTIONS')
{
    if(isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         

    if(isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
        header("Access-Control-Allow-Headers: {$_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]}");
}

//autoload de composer
include_once '../vendor/autoload.php';
//arranque de mis utilidades
include_once '../vendor/theframework/bootstrap.php';
//rutas, mapeo de url->controlador.metodo()
$arRoutes = include_once '../src/routes/routes.php';
$sRequestUri = $_SERVER["REQUEST_URI"];
$arUri = explode("?",$sRequestUri);
$sUri = $arUri[0];

//aqui se guardará los datos de controlador y método a ejecutar
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

//si no se ha encontrado una url en las rutas se asigna la última
//que está asociada a la ruta 404
if(!$arRun) $arRun = $arRoute;
//limpio las rutas
unset($arRoutes);

//con el controlador devuelto en $arRun lo instancio
$oController = new $arRun["controller"]();
//ejecuto el método asociado
$oController->{$arRun["method"]}();
