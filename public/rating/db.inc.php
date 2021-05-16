<?php 

$servername="localhost";
$dbusername="root";
$dbpass = "";
$dbname = "Moto";

$conn = mysqli_connect($servername, $dbusername, $dbpass, $dbname);
// header("Content-type: text/html; charset=utf-8");
mysqli_set_charset($conn, 'UTF8');

    if(!$conn){
        die('connection to the database Failed'.mysqli_errno($conn));
    }
?>