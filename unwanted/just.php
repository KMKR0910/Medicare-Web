<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['name'])) {
    $userName = $_SESSION['name'];
} else {
    $userName = "Guest"; // Default if not logged in
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee Data</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Employee List</h2>

<table>
    <tr>
        <th>Name</th>
        <th>Contact</th>
        <th>Appointment date</th>
        <th>Appointment Time</th>
        <th>Appointment Number</th>
    </tr>

<?php
include "log1.php"; // Database connection

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select query (assume you pass in a customer_id from somewhere, e.g., session)
$customer_id = 123; // Example value
$sql = "SELECT patient_name, conta, app_date, app_num, app_time FROM appointment1 WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id); // Assuming customer_id is an integer
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["patient_name"] . "</td><td>" . $row["conta"] . "</td><td>" . $row["app_date"] . "</td><td>" . $row["app_time"] . "</td><td>" . $row["app_num"] . "</td></tr>";
    }
} else {
    echo "<tr><td colspan='5'>No results found</td></tr>";
}

$conn->close();
?>

</table>

</body>
</html>
