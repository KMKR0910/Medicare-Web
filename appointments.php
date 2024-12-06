<?php
session_start(); // Start the session
include "log1.php"; // Include your database connection file

// Check if customer_id is set in the session
if (isset($_SESSION['customer_id'])) {
    $customerId = $_SESSION['customer_id'];

    // Prepare the SQL statement to fetch data for the specific customer_id
    $stmt = $conn->prepare("SELECT * FROM appointment1 WHERE customer_id = ?");
    $stmt->bind_param("i", $customerId); // Assuming customer_id is an integer

    // Execute the statement
    if ($stmt->execute()) {
        $result = $stmt->get_result(); // Get the result set

        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            // Fetch and display the data
            while ($row = $result->fetch_assoc()) {
                // Access your row data using $row['column_name']
                echo "Name: " . htmlspecialchars($row['Dname']) . "<br>";
                echo "Type: " . htmlspecialchars($row['Dtype']) . "<br>";
                echo "Quantity: " . htmlspecialchars($row['qty']) . "<br>";
                echo "Price: " . htmlspecialchars($row['price']) . "<br><br>";
            }
        } else {
            echo "No records found for this customer.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); // Close the statement
} else {
    echo "No customer ID found in session.";
}

// Close the database connection
$conn->close();
?>
