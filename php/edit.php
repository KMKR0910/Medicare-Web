<?php
session_start(); // Start or resume the session to access the logged-in user's ID
include 'log1.php'; // Include database connection

// Check if the user is logged in by verifying the session
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to update an appointment.";
    exit();
}

$customer_id = $_SESSION['user_id']; // Retrieve the logged-in user's ID from the session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize POST data to prevent SQL injection
    $apID = $_POST['id']; // The ID of the appointment to update
    $name = $_POST['patient_name']; // Patient name
    $contact = $_POST['conta']; // Contact info
    $date = $_POST['app_date']; // Appointment date
    $time = $_POST['app_time']; // Appointment time

    // Validate required fields
    if (empty($apID) || empty($name) || empty($contact) || empty($date) || empty($time)) {
        echo "All fields are required.";
        exit();
    }

    // MSSQL Query to update the appointment
    $sql = "UPDATE Appointment 
            SET name = ?, contact = ?, date = ?, time = ? 
            WHERE apID = ? AND patientID = ?";
    $stmt = sqlsrv_prepare($conn, $sql, array(&$name, &$contact, &$date, &$time, &$apID, &$customer_id));

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Execute the query
    if (sqlsrv_execute($stmt)) {
        // Redirect to PatientD.php with updated appointment details
        header("Location: PatientD.php?app_num=" . urlencode($apID) . 
            "&name=" . urlencode($name) . 
            "&contact=" . urlencode($contact) . 
            "&date=" . urlencode($date) . 
            "&time=" . urlencode($time));
        exit();
    } else {
        // Handle error case, redirect with an error message
        $error_message = "Error: " . print_r(sqlsrv_errors(), true);
        header("Location: PatientD3.php?error_message=" . urlencode($error_message));
        exit();
    }
} else {
    echo "Invalid request method.";
    exit();
}

// Close the statement and connection
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
