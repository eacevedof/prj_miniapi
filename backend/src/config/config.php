<?php
//config.php
if(!defined("ENV")) define("ENV","d");

$arConfig = [
    //d: development
    "d" => [
        "db"=>[
            "server"=>"localhost",
            "database"=>"employees",
            "user"=>"root",
            "password"=>""
        ]
    ],
    //p: production
    "p" => [
        "db"=>[
            "server"=>"localhost",
            "database"=>"employees",
            "user"=>"root",
            "password"=>"" 
        ]        
    ]
];

return $arConfig[ENV];