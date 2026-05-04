<?php
session_start();
include "log1.php"; // Database connection

// Initialize variables
$email = $_POST['email'];
$password = $_POST['password'];
$is_login_successful = false;
$error_message = "";

// Check if the email exists
$login_sql = "SELECT * FROM signin WHERE email = ?";
$stmt = mysqli_prepare($conn, $login_sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    // User found, check password
    $user_data = mysqli_fetch_assoc($result);
    $hashed_password = $user_data['password'];

    if (password_verify($password, $hashed_password)) {
        // Password is correct, set session variables
        $_SESSION['name'] = $user_data['name'];
        $_SESSION['user_id'] = $user_data['id'];
        $is_login_successful = true;
    } else {
        $error_message = "Invalid password.";
    }
} else {
    $error_message = "Invalid email.";
}

// Close the connection
mysqli_close($conn);

// Redirect based on login success
if ($is_login_successful) {
    header("Location: PatientD.php");
    exit();
} else {
    // Redirect back to login with error
    $_SESSION['login_error'] = $error_message;
    header("Location: logP.php"); // Assuming logP.php is the login page
    exit();
}
?>
