<?php
include "log1.php"; // Include your database connection file
session_start();

// Check if the user is logged in and customer_id is available
if (!isset($_SESSION['customer_id'])) {
    header("Location: logP.html"); // Redirect to login page if not logged in
    exit();
}

// Get the customer_id from the session
$customer_id = $_SESSION['customer_id'];

// Prepare the SQL query to fetch appointments
$sql = "SELECT * FROM appointment1 WHERE customer_id = ?";

if ($stmt = $conn->prepare($sql)) {
    // Bind the customer_id parameter
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Store appointment data
    $appointments = array();

    // Check if any rows were found
    if ($result->num_rows > 0) {
        // Fetch all appointment records
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
    } else {
        $error_message = "No appointments found.";
    }

    $stmt->close(); // Close the statement
} else {
    $error_message = "Error preparing statement: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
