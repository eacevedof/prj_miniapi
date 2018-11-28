<?php
if(!defined("ENV")) define("ENV","d");

$arConfig = [
    //development
    "d" => [
        "db"=>[
            "server"=>"localhost",
            "database"=>"employees",
            "user"=>"root",
            "password"=>""
        ]
    ],
    //production
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