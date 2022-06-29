<?php

namespace App\Controllers;
use Slim\Views\Twig as View;
use PDO;

class TestController
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

    ////////////////// CRUD with MySQLi Method ///////////////////////////
    //GET ALL DATA :GET
    public function getData($request, $response)
    {
        $db = connect_db();
        $sql = "SELECT * FROM test_table";
        $exe = $db->query($sql);
        $data = $exe->fetch_all(MYSQLI_ASSOC);
        echo json_encode($data);
    }

    //GET SINGLE DATA :GET
    public function getDataSingle($request, $response, $params)
    {
        $db = connect_db();
        $sql = "SELECT * FROM test_table WHERE `id` = '$params[id]'";
        $exe = $db->query($sql);
        $data = $exe->fetch_all(MYSQLI_ASSOC);
        echo json_encode($data);
    }

    //Add DATA :POST
    public function addData($request, $response)
    {
        $input = $request->getParsedBody();
        $data = $input['data'];
        $createdAt = time();
        $db = connect_db();
        $sql = "insert into test_table (data,createdAt)"
                . " VALUES('$data','$createdAt')";
        $exe = $db->query($sql);
        $last_id = $db->insert_id;
        $db = null;
        if (!empty($last_id))
            echo $last_id;
        else
            echo false;
    }

    //UPDATE DATA :PUT
    public function updateData($request, $response, $params)
    {
        $input = $request->getParsedBody();
        $data = $input['data'];
        $createdAt = time();
        $db = connect_db();
        $sql = "UPDATE test_table SET data = '$data',createdAt = '$createdAt'"
                . " WHERE id = '$params[id]'";
        $exe = $db->query($sql);
        $last_id = $db->affected_rows;
        $db = null;
        if (!empty($last_id))
            echo $last_id;
        else
            echo false;
    }

    //DELETE DATA :POST
    public function deleteData($request, $response, $params)
    {
        $db = connect_db();
        $sql = "DELETE FROM test_table WHERE `id` = '$params[id]'";
        $exe = $db->query($sql);
        $db = null;
        if (!empty($last_id))
            echo $last_id;
        else
            echo false;
    }

     ////////////////// CRUD with PDO Method ///////////////////////////
     //ADD DATA :GET
     public function getDataPDO($request, $response)
     {
         $statement = $this->db->prepare("SELECT * FROM test_table");
         $statement->execute();
         $results = $statement->fetchAll(PDO::FETCH_ASSOC);
         return $json = json_encode($results);
     }

     //GET SINGLE DATA :GET
     public function getDataSinglePDO($request, $response, $params)
     {
         $statement = $this->db->prepare("SELECT * FROM test_table WHERE `id` = '$params[id]' ");
         $statement->execute();
         $results = $statement->fetchAll(PDO::FETCH_ASSOC);
         return $json = json_encode($results);
     }

     //ADD DATA :POST
     public function addDataPDO($request, $response, $params)
     {
         $input = $request->getParsedBody();
         $query = $this->db->prepare("INSERT INTO test_table SET data = :data, createdAt = :createdAt");
         
         if($query->execute([
             'data' =>  $input['data'],
             'createdAt' => time()
         ])){
            echo json_encode(
                 array('message' => 'Data Created')
            );
         } else {
            echo json_encode(
                 array('message' => 'Data Not Created')
            );
         }
        
     }

    //UPDATE DATA :PUT
    public function updateDataPDO($request, $response, $params)
    {
        $input = $request->getParsedBody();
        $query = $this->db->prepare("UPDATE test_table SET data = :data, createdAt = :createdAt WHERE id = :id");
        
        if($query->execute([
            'id'=> $params['id'],
            'data' =>  $input['data'],
            'createdAt' => time()
        ])){
            echo json_encode(
                array('message' => 'Data Updated')
            );
        } else {
            echo json_encode(
                array('message' => 'Data Not Updated')
            );
        }
        
    }

    //DELETE DATA :POST
    public function deleteDataPDO($request, $response, $params)
    {
        $input = $request->getParsedBody();
        $query = $this->db->prepare("DELETE FROM test_table WHERE id = :id");
        
        if($query->execute([
            'id'=> $params['id']
        ])){
            echo json_encode(
                array('message' => 'Data Deleted')
            );
        } else {
            echo json_encode(
                array('message' => 'Data Not Deleted')
            );
        }
        
    }

}