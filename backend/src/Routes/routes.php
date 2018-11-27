<?php
//mapeo de rutas y controladores
return [
    ["url"=>"/","controller"=>"App\Controllers\EmpleadosController","method"=>"index"],
    ["url"=>"/404","controller"=>"App\Controllers\NotFoundController","method"=>"index"]
];
