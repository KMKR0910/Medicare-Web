<?php
include "log1.php"; // This file should contain your database connection

// Start the session
session_start();

// Check if the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data using POST method
    $email = $_POST['email'];
    $password = $_POST['password']; // Plain password entered by the user

    // Prepare the SQL query to check if the user exists with the entered email and password
    $sql = "SELECT * FROM signin WHERE email = ? AND password = ?";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        // Here we're binding the plaintext password, which is NOT recommended!
        $stmt->bind_param("ss", $email, $password);

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Check if any user was found with the given email and password
        if ($result->num_rows > 0) {
            // Fetch the user data
            $row = $result->fetch_assoc();

            // If you reach here, it means the login is successful
            echo "Login successful! Welcome, " . $row['email'];
        
            // Store user information in session
            $_SESSION['user_id'] = $row['id']; // Assuming you have an 'id' field in your table
        
            // Redirect to the dashboard or homepage
            header("Location: PatientD.php");
            exit();
        } else {
            // Handle the error for invalid credentials
            echo "Invalid email or password. Please try again.";
        }

        // Close the statement
        $stmt->close();
    } else {
        // Error occurred while preparing the statement
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the connection
    mysqli_close($conn);
}
?>
