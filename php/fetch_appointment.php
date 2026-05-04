<?php
// Include your database connection
include 'log1.php'; // Ensure you have your connection settings here

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the appointment number (ID) from the POST request
    $apID = $_POST['appointment_id']; // Change this to match the name used in your HTML

    // Prepare the SQL query to fetch the appointment details
    $sql = "SELECT name, contact, date ,  time FROM Appointment WHERE apID = ?";

    // Prepare the statement
    $stmt = sqlsrv_prepare($conn, $sql, array(&$apID));

    if ($stmt === false) {
        // Error occurred while preparing the statement
        echo json_encode(array("error" => "Error preparing the statement: " . print_r(sqlsrv_errors(), true)));
        exit();
    }

    // Execute the statement
    if (sqlsrv_execute($stmt)) {
        // Fetch the data
        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            // Format date and time if they are valid DateTime objects
            $date = $row['date'] ? $row['date']->format('Y-m-d') : null;
            $time = $row['time'] ? $row['time']->format('H:i:s') : null;

            // Populate the form fields with the fetched data as JSON
            echo json_encode(array(
                "name" => $row['name'], // Change key to match JavaScript expectations
                "contact" => $row['contact'],
                "date" => $date, // Change key to match JavaScript expectations
                "time" => $time  // Change key to match JavaScript expectations
            ));
        } else {
            // No data found for the given apID
            echo json_encode(array("error" => "No appointment found for the given ID."));
        }
    } else {
        // Error occurred while executing the statement
        echo json_encode(array("error" => "Error executing the statement: " . print_r(sqlsrv_errors(), true)));
    }

    // Free the statement resources
    sqlsrv_free_stmt($stmt);
} else {
    // Invalid request method
    echo json_encode(array("error" => "Invalid request method."));
}

// Close the database connection
sqlsrv_close($conn);
?>