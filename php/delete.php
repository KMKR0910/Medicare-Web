<?php
include 'log1.php'; // Ensure you include the correct path to your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data and sanitize it
    $apID = isset($_POST['appointment_id']) ? $_POST['appointment_id'] : null; // Use the correct form field name

    if ($apID) { // Check if appointment ID is provided
        // Prepare SQL query to delete the appointment
        $sql = "DELETE FROM Appointment WHERE apID = ?"; // Corrected SQL syntax

        // Prepare the statement
        $stmt = sqlsrv_prepare($conn, $sql, array(&$apID));

        if ($stmt === false) {
            // Error occurred while preparing the statement
            echo "Error preparing statement: " . print_r(sqlsrv_errors(), true);
            exit();
        }

        // Attempt to execute the prepared statement
        if (sqlsrv_execute($stmt)) {
            echo "Appointment deleted successfully.";
            // Redirect to the PatientD.php page after a short delay
            header("Location: PatientD.php");
            exit();
        } else {
            // Provide detailed error message if execution fails
            echo "Error deleting appointment: " . print_r(sqlsrv_errors(), true);
        }

        // Free the statement resources
        sqlsrv_free_stmt($stmt);
    } else {
        echo "No appointment ID provided.";
    }
}

// Close the database connection
sqlsrv_close($conn);
?>
