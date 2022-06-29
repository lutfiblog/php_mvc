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

    public function IoT($request, $response)
    {
        $authTable = $this->db->exec("CREATE TABLE auth(
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(256) NOT NULL,
            password VARCHAR(256) NOT NULL,
            apikey VARCHAR(256) NOT NULL,
            createdAt VARCHAR(256) NOT NULL
        )");

        $data_record = $this->db->exec("CREATE TABLE data_record(
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            deskripsi VARCHAR(256) NOT NULL,
            nama_record VARCHAR(256) NOT NULL,
            user_id VARCHAR(256) NOT NULL,
            createdAt VARCHAR(256) NOT NULL
        )");

        $data_table = $this->db->exec("CREATE TABLE data_table(
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            data JSON NOT NULL,
            deviceName VARCHAR(256) NOT NULL,
            apikey VARCHAR(256) NOT NULL,
            record_id VARCHAR(256) NOT NULL,
            createdAt VARCHAR(256) NOT NULL
        )");
        
        return "Sucessfully added table";


        
    }

    public function Playground($request, $response)
    {
        $testTable = $this->db->exec("CREATE TABLE test_table(
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            data VARCHAR(256) NOT NULL,
            createdAt VARCHAR(256) NOT NULL
        )");

        return "Sucessfully added Table";
    }
}