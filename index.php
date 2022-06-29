<?php 

require 'vendor/autoload.php';
// require 'lib/db.php';
//require 'getEmployee.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
    ]
]);

$container = $app->getContainer();

//using PDO
$container['db'] = function() {
    return new PDO('mysql:host=31.220.110.101;dbname=u796089999_playground', 'u796089999_playground', 'Playground123');
};

//using MySQLi
function connect_db() {
    $server = '31.220.110.101'; 
    $user = 'u796089999_playground';
    $pass = 'Playground123';
    $database = 'u796089999_playground'; 
    $connection = new mysqli($server, $user, $pass, $database);

    return $connection;
};


$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__.'/app/views', [
        //'cache' => 'false'
    ]);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};

//// REGISTER CONTROLLER
$container['ModelController'] = function($container) {
    return new \App\Controllers\ModelController($container->db);
};

$container['SeedTableController'] = function($container) {
    return new \App\Controllers\SeedTableController($container->db);
};

$container['HomeController'] = function($container) {
    return new \App\Controllers\HomeController($container->view, $container->db);
};

$container['IoTController'] = function($container) {
    return new \App\Controllers\IoTController($container->view, $container->db);
};

$container['TestController'] = function($container) {
    return new \App\Controllers\TestController($container->view, $container->db);
};

    
/////////////////////// MODEL ROUTE ////////////////////////
$app->group('/model', function(){
    $this->get('/iot', 'ModelController:IoT'); //GENERATE IOT TABLE
    $this->get('/playground', 'ModelController:Playground'); //GENERATE IOT TABLE
});


//////////////////////////////// INDEX VIEW //////////////////////////////////////
$app->get('/maketable', 'ModelController:persons');

$app->group('/', function(){
    $this->get('', 'HomeController:index');
    $this->get('test', 'HomeController:test');
    $this->get('test/{id}', 'HomeController:testGetName');
});


$app->get('/test/param/{slug}/{slug2}', function($request, $response, $params){
    return 'Test param berisi = '.$params['slug'].'       '.$params['slug2'];
});


/////////////////// IOT ////////////////////////////
$app->group('/iot', function(){
    $this->get('/auth', 'IoTController:getAllUser');
    $this->post('/auth/signup', 'IoTController:authSignup');
    $this->post('/auth/login', 'IoTController:authLogin');

    $this->post('/data/record', 'IoTController:dataRecord');
    $this->get('/data/record', 'IoTController:getAllDataRecord');
    $this->get('/data/table', 'IoTController:getAllDataTable');
});

/////////////////// PLAYGROUND ////////////////////////////
$app->group('/playground', function(){
    //MySQLi Method
    $this->get('/mysqli', 'TestController:getData');
    $this->get('/mysqli/{id}', 'TestController:getDataSingle');
    $this->post('/mysqli', 'TestController:addData');
    $this->put('/mysqli/{id}', 'TestController:updateData');
    $this->post('/mysqli/{id}', 'TestController:deleteData');

    //PDO Method
    $this->get('/pdo', 'TestController:getDataPDO');
    $this->get('/pdo/{id}', 'TestController:getDataSinglePDO');
    $this->post('/pdo', 'TestController:addDataPDO');
    $this->put('/pdo/{id}', 'TestController:updateDataPDO');
    $this->post('/pdo/{id}', 'TestController:deleteDataPDO');
});


$app->run();
