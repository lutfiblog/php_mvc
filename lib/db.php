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