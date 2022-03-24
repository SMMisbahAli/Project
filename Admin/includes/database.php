<?php

    $dbhost="localhost";
    $dbUser="root";
    $dbPass="";
    $dbName="admin panel";

    $conn=mysqli_connect($dbhost,$dbUser,$dbPass,$dbName);

    if(!$conn)
    {
        die("Data Base connection Failed") ;
    }
    

?>