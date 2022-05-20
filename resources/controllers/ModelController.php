<?php

namespace App\Controllers;

class ModelController
{
    //Config
    protected $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }
    //EndConfig

    public function persons($request, $response)
    {
        $newtable = $this->db->exec("CREATE TABLE persons(
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            first_name VARCHAR(30) NOT NULL,
            last_name VARCHAR(30) NOT NULL,
            email VARCHAR(70) NOT NULL UNIQUE
        )");
    
        return "created new table person $newtable";
    }
}