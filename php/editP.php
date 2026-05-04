<?php
session_start();
include "log1.php"; // Ensure this file establishes a connection to your MS SQL Server

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $orderID = $_POST['Order_ID'];
    $drugName = $_POST['Drug_Name'];
    $packSize = $_POST['Pack_Size'];
    $quantity = $_POST['Quantity'];

    // Ensure Supplier_ID is set in the session
    if (isset($_SESSION['Supplier_ID'])) {
        $supplierID = $_SESSION['Supplier_ID'];

        // Prepare the update query
        $sql = "UPDATE DrugOrderItem 
                SET Drug_Name = ?, Pack_Size = ?, Quantity = ? 
                WHERE Item_ID = ? AND Supplier_ID = ?";

        // Bind parameters
        $params = array($drugName, $packSize, $quantity, $orderID, $supplierID);
        
        // Execute the query
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt) {
            echo "Order updated successfully.";
            header("Location: dashboardS.php"); // Redirect to dashboard
            exit();
        } else {
            echo "Error updating the order. ";
            if (($errors = sqlsrv_errors()) != null) {
                foreach ($errors as $error) {
                    echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
                    echo "Code: " . $error['code'] . "<br />";
                    echo "Message: " . $error['message'] . "<br />";
                }
            }
        }

        sqlsrv_free_stmt($stmt);
    } else {
        echo "Error: Supplier not logged in.";
    }

    // Close the connection
    sqlsrv_close($conn);
} else {
    echo "Invalid request method.";
}
?>
