<?php

namespace App\Controllers;
use Slim\Views\Twig as View;
use PDO;

class EmployeeController
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


    public function index($request, $response)
    {
        $db = connect_db();
        $sql = "SELECT * FROM employee ORDER BY `emp_name`";
        $exe = $db->query($sql);
        $data = $exe->fetch_all(MYSQLI_ASSOC);
        $db = null;
        echo json_encode($data);
    }

    public function GetbyId($request, $response, $args)
    {
        $employee = $this->db->prepare("SELECT * FROM employee where employee_id = :employee_id");
        $employee->execute([
            'employee_id' => $args['employee_id']
        ]);
        var_dump($employee->fetch(PDO::FETCH_OBJ));
    }
}