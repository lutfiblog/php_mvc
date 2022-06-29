<?php

namespace App\Controllers;

class SeedTableController
{
    //Config
    protected $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }
    //EndConfig

    public function Seed($request, $response)
    {
    
        return "created new table person $newtable";
    }

}