<?php

$servername = "LAPTOP-8TNGUHH5";
$dbname = "dip1";

// Use Windows Authentication
$conn = sqlsrv_connect($servername, array("Database" => $dbname));

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
} 
 
?>
