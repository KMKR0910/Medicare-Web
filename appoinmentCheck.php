<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php


session_start();
include "log1.php"; // Database connection

$appointmentNumber = "--";
$startTime = "-- : --";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Check'])) {
    $date = $_POST['date'];

    if (empty($date)) {
        echo "Please select a date.";
        exit();
    }

    try {
        // SQL query to fetch the first available appointment
        $sql = "SELECT TOP 1 [AppointmentNumber], [StartTime]
                    FROM [DoctorSessions]
                    WHERE CAST([SessionDate] AS DATE) = ? AND [AppointmentStatus] = 'Available'
                    ORDER BY [StartTime] ASC";
            $stmt = sqlsrv_prepare($conn, $sql, array($date));

        if (!$stmt) {
            throw new Exception("Failed to prepare query: " . print_r(sqlsrv_errors(), true));
        }

        if (sqlsrv_execute($stmt)) {
            if (sqlsrv_has_rows($stmt)) {
                $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
               $appointmentNumber = "123"; // Replace with fetched appointment number
    $startTime = "10:00 AM";

            }else {
                echo "No appointments are available for this day.";
                $appointmentNumber = '';
                $startTime = '';
                // Debugging the variable with var_dump
var_dump($appointmentNumber);
            }
        } else {
            throw new Exception("Failed to execute query: " . print_r(sqlsrv_errors(), true));
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
