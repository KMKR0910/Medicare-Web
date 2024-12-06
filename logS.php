<?php
session_start();
include "log1.php"; // Ensure this file sets up your MS SQL Server connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $fname = $_POST['Fname'];
    $lname = $_POST['Lname'];
    $companyName = $_POST['Company_name'];
    $address = $_POST['Address'];
    $email = $_POST['Email_Address'];
    $password = $_POST['Password'];

    // Prepare the INSERT query
    $sql = "INSERT INTO DrugSupplier (Fname, Lname, Company_name, Address, Email_Address, Password)
            OUTPUT INSERTED.Supplier_ID
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $params = array($fname, $lname, $companyName, $address, $email, $password);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Fetch the inserted Supplier_ID
    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $_SESSION['Fname'] = $fname;
        $_SESSION['Supplier_ID'] = $row['Supplier_ID']; // Store Supplier_ID in session

        echo "New record created successfully.";
        $is_registration_successful = true;
    } else {
        $is_registration_successful = false;
    }

    // Close the connection
    sqlsrv_close($conn);

    // Redirect or display error based on the registration outcome
    if ($is_registration_successful) {
        header("Location: dashboardS.php"); // Redirect to supplier dashboard
        exit();
    } else {
        echo "Error: Unable to register supplier. Please try again later.";
    }
} else {
    echo "Invalid request method.";
}
?>
