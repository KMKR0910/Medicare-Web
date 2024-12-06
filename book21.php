<?php
session_start(); // Start or resume the session to access the logged-in user's ID
include 'log1.php'; // Database connection

// Check if the user is logged in by verifying the session
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to make a booking.";
    exit();
}

$customer_id = $_SESSION['user_id']; // Retrieve the logged-in user's ID from the session

// Sanitize POST data to prevent SQL injection
$name = trim($_POST['name']);
$contact = trim($_POST['contact']);
$date = $_POST['date'];
$time = $_POST['time'];

// Validate required fields
if (empty($name) || empty($contact) || empty($date) || empty($time)) {
    echo "All fields are required.";
    exit();
}

// MSSQL Query to insert data into Appointment table
$sql = "INSERT INTO Appointment (name, contact, date, time, patientID) VALUES (?, ?, ?, ?, ?)";
$params = array($name, $contact, $date, $time, $customer_id);
$stmt = sqlsrv_prepare($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Execute the query
if (sqlsrv_execute($stmt)) {
    // Retrieve the last inserted ID (appointment ID)
    $sqlLastId = "SELECT SCOPE_IDENTITY() AS apID";
    $lastIdResult = sqlsrv_query($conn, $sqlLastId);
    
    if ($lastIdResult && $row = sqlsrv_fetch_array($lastIdResult, SQLSRV_FETCH_ASSOC)) {
        $app_num = $row['apID'];
        
        // Redirect to PatientD.php with appointment details
        header("Location: PatientD.php?app_num=" . urlencode($app_num) .
            "&name=" . urlencode($name) .
            "&contact=" . urlencode($contact) .
            "&date=" . urlencode($date) .
            "&time=" . urlencode($time));
        exit();
    } else {
        // Handle error case retrieving last ID
        $error_message = "Error retrieving appointment ID.";
        header("Location: PatientD3.php?error_message=" . urlencode($error_message));
        exit();
    }
} else {
    // Handle error case for execution failure
    $error_message = "Error executing query: " . print_r(sqlsrv_errors(), true);
    header("Location: PatientD3.php?error_message=" . urlencode($error_message));
    exit();
}

// Close the statement and connection
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>