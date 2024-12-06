<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve posted data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare content to download
    $content = "User Profile\n";
    $content .= "ID: $id\n";
    $content .= "Name: $name\n";
    $content .= "Contact: $contact\n";
    $content .= "Email: $email\n";
    $content .= "Password: $password\n";

    // Specify file name
    $fileName = "user_profile_$id.txt";

    // Set headers to download the file
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    
    // Output the content
    echo $content;
    exit;
}
?>
