<?php
session_start();
include "log1.php"; // Database connection

// Retrieve form data using POST method
$name = $_POST['name'];
$address = $_POST['address'];
$DOB = $_POST['DOB'];
$gender = $_POST['gender'];
$Cno = $_POST['Cno'];
$email = $_POST['email'];
$password = $_POST['password']; // Ensure 'password' is captured correctly

// Initialize registration status
$is_registration_successful = false;

// Check if the contact number already exists
$check_Cno_sql = "SELECT * FROM patientSign WHERE Cno = ?";
$params = array($Cno);
$check_Cno_stmt = sqlsrv_query($conn, $check_Cno_sql, $params);

if ($check_Cno_stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

if (sqlsrv_has_rows($check_Cno_stmt)) {
    echo "Error: The contact number already exists. Please use a different contact.";
} else {
    // If contact is unique, proceed with the insertion
    $sql = "INSERT INTO  patientSign (name, Cno, email, password, gender, address, DOB) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $params = array($name, $Cno, $email, $password, $gender, $address, $DOB);
    $insert_stmt = sqlsrv_query($conn, $sql, $params);

    if ($insert_stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        // Change the status to true if the query is successful
        $is_registration_successful = true;
        $_SESSION['name'] = $name;

        // Retrieve the user ID of the newly inserted user
        $query = "SELECT SCOPE_IDENTITY() AS user_id";
        $result = sqlsrv_query($conn, $query);
        if ($result !== false && sqlsrv_fetch($result)) {
            $user_id = sqlsrv_get_field($result, 0);
            $_SESSION['user_id'] = $user_id;
        }

        echo "New record created successfully";
    }
}

// Close the connection
sqlsrv_free_stmt($check_Cno_stmt);
sqlsrv_free_stmt($insert_stmt);
sqlsrv_close($conn);

// Redirect to the dashboard or display the error based on the success of registration
if ($is_registration_successful) {
    header("Location: PatientD.php");
    exit();
} else {
    // Handle the error case
    echo "Registration failed!";
}
?>
