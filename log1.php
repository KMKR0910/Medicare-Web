<?php

$servername = "ASUS";
$dbname = "Diploma Final Project DB1";

// Use Windows Authentication
$conn = sqlsrv_connect($servername, array("Database" => $dbname));

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
} 
 
?>
