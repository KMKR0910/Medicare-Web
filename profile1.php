<?php
include "log1.php"; // Include your database connection file
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: logP.html"); // Redirect to login page if not logged in
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Prepare the SQL query to fetch user details
$sql = "SELECT * FROM signin WHERE id = ?"; // Assuming 'id' is the primary key
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $user_id); // Bind the user ID parameter
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user was found
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Fetch user data as an associative array
        header("Location: profile.php");
    } else {
        echo "No user found.";
        exit();
    }

    $stmt->close(); // Close the statement
} else {
    echo "Error preparing statement: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
