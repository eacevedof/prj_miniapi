<?php
//mapeo de rutas y controladores

return [   
/*  
Listado de employees con el departamento, cargo y salario actuales. 
Ordenado por fecha de contratación y limitado a 50 
*/  
    ["url"=>"/","controller"=>"App\Controllers\NotFoundController","method"=>"index"],
    ["url"=>"/employees","controller"=>"App\Controllers\EmployeesController","method"=>"index"],
    ["url"=>"/employees/","controller"=>"App\Controllers\EmployeesController","method"=>"index"],
//Obtención del perfil de un empleado con el departamento, 
//cargo y salario actuales. Los campos a devolver son:    
    ["url"=>"/employees/profile","controller"=>"App\Controllers\EmployeesController","method"=>"profile"],
    ["url"=>"/employees/profile/","controller"=>"App\Controllers\EmployeesController","method"=>"profile"],
//Inserción de un empleado con los siguientes parámetros: 
    ["url"=>"/employees/insert","controller"=>"App\Controllers\EmployeesController","method"=>"insert"],
    ["url"=>"/employees/insert/","controller"=>"App\Controllers\EmployeesController","method"=>"insert"],
//para cargar selects
    ["url"=>"/picklists/departments","controller"=>"App\Controllers\PicklistController","method"=>"departments"],
    ["url"=>"/picklists/departments/","controller"=>"App\Controllers\PicklistController","method"=>"departments"],
    ["url"=>"/picklists/titles","controller"=>"App\Controllers\PicklistController","method"=>"titles"],
    ["url"=>"/picklists/titles/","controller"=>"App\Controllers\PicklistController","method"=>"titles"],

//resto de rutas
    ["url"=>"/404","controller"=>"App\Controllers\NotFoundController","method"=>"error_404"]
];
