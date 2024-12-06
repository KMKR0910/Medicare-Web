<?php
session_start();
include "log1.php"; // Include your MS SQL connection setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $drugName = trim($_POST['Drug_Name']);
    $packSize = trim($_POST['Pack_Size']);
    $quantity = intval($_POST['Quantity']); // Ensure quantity is an integer

    // Check if the Supplier_ID is available in the session
    if (isset($_SESSION['Supplier_ID'])) {
        $supplierID = $_SESSION['Supplier_ID'];
    } else {
        die("Error: Supplier not logged in.");
    }

    // Prepare and execute SQL INSERT statement
    $sql = "INSERT INTO DrugOrderItem (Drug_Name, Pack_Size, Quantity, supplier_ID) 
            VALUES (?, ?, ?, ?)";

    // Prepare the SQL statement
    $params = array($drugName, $packSize, $quantity, $supplierID);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        // Display detailed error message if query fails
        echo "Error: Unable to place the order.<br>";
        if (($errors = sqlsrv_errors()) != null) {
            foreach ($errors as $error) {
                echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
                echo "Code: " . $error['code'] . "<br>";
                echo "Message: " . $error['message'] . "<br>";
            }
        }
    } else {
        echo "Order placed successfully!";
        // Redirect to the dashboard after successful order placement
        header("Location: dashboardS.php");
        exit();
    }

    // Free the statement and close the connection
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
} else {
    echo "Invalid request method.";
}
?>
