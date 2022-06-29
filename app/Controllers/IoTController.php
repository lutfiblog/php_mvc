<?php

namespace App\Controllers;
use Slim\Views\Twig as View;
use PDO;
use \Firebase\JWT\JWT;

class IoTController
{
    //Config
    protected $view;
    protected $db;

    public function __construct(View $view, $db)
    {
        $this->view = $view;
        $this->db = $db;
    }
    //EndConfig


    public function getAllUser($request, $response)
    {
        $statement = $this->db->prepare("SELECT * FROM auth WHERE username = 'lutfiii'");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $json = json_encode($results);
    }

    public function authSignup($request, $response)
    {
        $input = $request->getParsedBody();
        $query = $this->db->prepare("INSERT INTO auth SET username = :username, password= :password, apikey = :apikey, createdAt = :createdAt");
        
        if($query->execute([
            'username' =>  $input['username'],
            'password' => password_hash($input['password'], PASSWORD_BCRYPT),
            'apikey' => crypt($input['username'], $input['password']),
            'createdAt' => time()
        ])){
            echo json_encode(
                array('message' => 'User Created')
                );
        } else {
            echo json_encode(
                array('message' => 'User Not Created')
                );
        }
    }
    public function authLogin($request, $response)
    {
        $input = $request->getParsedBody();
        $password = $input['password'];
        $query = $this->db->prepare("SELECT * FROM auth WHERE username = :username");
        $query->execute([
            'username' => $input['username']
        ]);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if(password_verify($password, $row['password'])){
            echo json_encode(
                array(
                    'message' => 'Login Success',
                    'username' => $row['username'],
                    'apikey' => $row['apikey'],
                    'user_id' => $row['id']
                )
                );
        } else {
            echo json_encode(
                array('message' => 'Login Unsuccessful or Wrong Password')
            );
        }
    }

    public function dataRecord($request, $response)
    {
        $input = $request->getParsedBody();
        $query = $this->db->prepare("INSERT INTO data_record SET deskripsi = :deskripsi, nama_record = :nama_record, user_id = :user_id, createdAt = :createdAt");

        if($query->execute([
            'deskripsi' =>  $input['deskripsi'],
            'nama_record' =>  $input['nama_record'],
            'user_id' =>  $input['user_id'],
            'createdAt' => time()
        ])){
            echo json_encode(
                array('message' => 'Record Data Created')
            );
        } else {
            echo json_encode(
                array('message' => 'Record Data Not Created')
            );
        }
    }

    public function getAllDataRecord($request, $response)
    {
        $statement = $this->db->prepare("SELECT * FROM data_record");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $json = json_encode($results);
    }

    public function getAllDataTable($request, $response)
    {
        $statement = $this->db->prepare("SELECT * FROM test_table");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $json = json_encode($results);
    }

    
}