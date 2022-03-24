<?php
    $host= '127.0.1'; //localhost IP address is also same
    $db='users';
    $user='root';
    $password='';
    $charset='utf8mb4';

    $dsn="mysql:host=$host;dbname=$db;charset=$charset"; // data source name

    $try={
        $pdo= new PDOO($dsn);

    } catch(){

    }
?>