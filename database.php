<?php

$host='localhost';
$username='root';
$user_pass='';
$database_in_use='msn_fast';

$g_projectTitle = "dashboardManagement";
$g_projectSlug = "dashboardManagement";
$g_primaryColor = "#007ed3";
$g_secondaryColor = "#007ed3";


$con = mysqli_connect($host,$username,$user_pass,$database_in_use);
if (!$con)
{
    echo"not connected";
}
if (!mysqli_select_db($con,$database_in_use))
{
    echo"database not selected";
}
?>