<?php
//mapeo de rutas y controladores

return [   
/*  
Listado de empleados con el departamento, cargo y salario actuales. 
Ordenado por fecha de contratación y limitado a 50 
*/  
    ["url"=>"/","controller"=>"App\Controllers\NotFoundController","method"=>"index"],
    ["url"=>"/empleados","controller"=>"App\Controllers\EmpleadosController","method"=>"index"],
    ["url"=>"/empleados/","controller"=>"App\Controllers\EmpleadosController","method"=>"index"],
//Obtención del perfil de un empleado con el departamento, 
//cargo y salario actuales. Los campos a devolver son:    
    ["url"=>"/empleados/profile","controller"=>"App\Controllers\EmpleadosController","method"=>"profile"],
    ["url"=>"/empleados/profile/","controller"=>"App\Controllers\EmpleadosController","method"=>"profile"],
//Inserción de un empleado con los siguientes parámetros: 
    ["url"=>"/empleados/insert","controller"=>"App\Controllers\EmpleadosController","method"=>"insert"],
    ["url"=>"/empleados/insert/","controller"=>"App\Controllers\EmpleadosController","method"=>"insert"],
//resto de rutas
    ["url"=>"/404","controller"=>"App\Controllers\NotFoundController","method"=>"error_404"]
];
