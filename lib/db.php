<?php

function connect_db() {
    $server = 'localhost'; 
    $user = 'root_user';
    $pass = 'root_password';
    $database = 'slim_phpdb'; 
    $connection = new mysqli($server, $user, $pass, $database);

    return $connection;
}
?>

{# return new PDO('mysql:host=sql596.main-hosting.eu;dbname=u796089999_apidb', 'u796089999_haslabs', 'Annisaku-2517'); #}
