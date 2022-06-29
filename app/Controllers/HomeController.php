<?php

namespace App\Controllers;
use Slim\Views\Twig as View;
use PDO;

class HomeController
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
        return $this->view->render($response,'home.twig');
    }

    public function test($request, $response)
    {
        return $this->view->render($response,'test.twig');
    }

    public function testGetName($request, $response, $args)
    {
        $user = $this->db->prepare("SELECT * FROM test_table where id = :id");
        $user->execute([
            'id' => $args['id']
        ]);
        $data = $user->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($user->fetch(PDO::FETCH_OBJ));

        return $this->view->render($response, 'test.twig', ['user' => $args['id']]);
    }
}