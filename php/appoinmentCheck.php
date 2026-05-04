<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "log1.php"; // Database connection

$appointmentNumber = "--";
$startTime = "-- : --";
$selectedDate=$_POST[appointment_date];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Check']))
 {
    $date = date('Y-m-d', strtotime($_POST['date']));


    if (empty($date)) {
        echo "Please select a date.";
        exit();
    }

    try {
        // SQL query to fetch the first available appointment
        $sql = "SELECT TOP 1 [AppointmentNumber], [StartTime]
                FROM [DoctorSessions]
                WHERE CAST([SessionDate] AS DATE) = ? AND [AppointmentStatus] = 'Avaliable'
                ORDER BY [StartTime] ASC";

        $params=[$selectedDate];
        $stmt = sqlsrv_query($conn, $sql, $params);
       // $stmt = sqlsrv_prepare($conn, $sql, array($date));

       if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $appointments = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $appointments[] = $row["AppointmentNumber"];
    }

    sqlsrv_free_stmt($stmt);
    
    ;}
    
    ?>
