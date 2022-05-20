<?php 

require 'vendor/autoload.php';
require 'lib/db.php';
require 'getEmployee.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
    ]
]);

$container = $app->getContainer();

$container['db'] = function() {
    return new PDO('mysql:host=localhost;slim_phpdb', 'root_user', 'root_password');
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__.'/resources/views', [
        //'cache' => 'false'
    ]);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};

$container['ModelController'] = function($container) {
    return new \App\Controllers\ModelController($container->db);
};

$container['HomeController'] = function($container) {
    return new \App\Controllers\HomeController($container->view, $container->db);
};

$container['EmployeeController'] = function($container) {
    return new \App\Controllers\EmployeeController($container->view, $container->db);
};



//////////////////////////////// INDEX VIEW //////////////////////////////////////
$app->get('/maketable', 'ModelController:persons');

$app->group('/', function(){
    $this->get('', 'HomeController:index');
    $this->get('test', 'HomeController:test');
    $this->get('test/{username}', 'HomeController:testGetName');
});


$app->get('/test/param/{slug}/{slug2}', function($request, $response, $params){
    return 'Test param berisi = '.$params['slug'].'       '.$params['slug2'];
});


//////////////////////// Employee ///////////////////////////////////////
$app->get('/employee', 'EmployeeController:index');
$app->get('/employee/{employee_id}', 'EmployeeController:GetbyId');

$app->post('/employee', function($request, $response, $args) {
    add_employee($request->getParsedBody());//Request object’s getParsedBody() method to parse the HTTP request 
});
$app->put('/update_employee', function($request, $response, $args) {
    update_employee($request->getParsedBody());
});
$app->delete('/delete_employee', function($request, $response, $args) {
    delete_employee($request->getParsedBody());
});




$app->run();
