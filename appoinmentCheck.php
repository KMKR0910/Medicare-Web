<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
                if ($row) {
                    $appointmentNumber = $row['AppointmentNumber']; // Fetch the appointment number
                    $startTime = $row['StartTime']->format('H:i:s'); // Format the start time
                } else {
                    echo "No data fetched.";
                }
            } else {
                echo "No appointments are available for this day.";
            }
        } else {
            throw new Exception("Failed to execute query: " . print_r(sqlsrv_errors(), true));
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>