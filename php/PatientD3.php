<?php
// Start the session only if it's not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session
}

// Check if the user is logged in
if (isset($_SESSION['name'])) {
    $userName = $_SESSION['name'];
} else {
    $userName = "Guest"; // Default if not logged in
}

include 'log1.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view your appointments.");
}

// Retrieve the logged-in user's ID
$customer_id = $_SESSION['user_id'];

// Prepare the SQL statement to fetch appointments using MS SQL Server
$query = "SELECT apID, name, contact, date, time FROM [dip1].[dbo].[Appointment] WHERE patientID = ?";

// Execute the query using sqlsrv
$params = array($customer_id); // The parameters to bind
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true)); // Print the error if the query fails
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="patientDashboard21.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            border-radius: 10px;
        }
        .profile-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-table {
            width: 100%; /* Make the table take full width */
            border-collapse: collapse; /* Merge borders */
            margin-top: 20px; /* Space above the table */
        }
        .profile-table th, .profile-table td {
            border: 1px solid #ddd; /* Light grey border for cells */
            padding: 10px; /* Add some padding */
            text-align: left; /* Align text to the left */
        }
        .profile-table th {
            background-color: #f2f2f2; /* Light grey background for headers */
            font-weight: bold; /* Bold text for headers */
        }
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <ul class="menu">
            <li class="active">
                            <a href="PatientD.php">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="profile12.php">
                                <i class="fas fa-user-alt"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="PatientD3.php">
                                <i class="fas fa-calendar-check"></i>
                                <span>Appointments</span>
                            </a>
                            
                        </li>
                        <li>
                            <a href="Prescript.php">
                                <i class="fas fa-file-prescription"></i>
                                <span>Prescription</span>
                            </a>
                            
                        </li>
                        <li>
                            <a href="PatientD3.php">
                                <i class="fas fa-vial"></i>
                                <span>Lab results</span>
                            </a>
                            
                        </li>

                        <li>
                            <a href="PatientD3.php">
                                <i class="fas fa-history"></i>
                                <span>Diagnose history</span>
                            </a>
                            
                        </li>
                     

                        <li class="logout">
                            <a href="HomePG.html">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Log Out</span>
                            </a>
                        </li>
            </ul>
        </div>
    </div>

    <div class="main--content">
        <div class="header--wrapper">
            <div class="header--title">
                <h1><?php echo htmlspecialchars($userName); ?>!</h1>
                <h2>Dashboard</h2>
            </div>
        </div>

        <div class="fieldsets">
            <h2>Your Appointments</h2>

            <?php
            // Check if any appointments were found
            if (sqlsrv_has_rows($stmt)) {
                // Display appointments in a table format
                echo "<table>";
                echo "<tr><th>Appointment Number</th><th>Patient Name</th><th>Contact</th><th>Date</th><th>Time</th></tr>";

                // Fetch and display each appointment
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['apID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['date']->format('Y-m-d')) . "</td>";
                    echo "<td>" . htmlspecialchars($row['time']->format('H:i')) . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No appointments found.</p>";
            }

            // Close the statement and connection
            sqlsrv_free_stmt($stmt);
            sqlsrv_close($conn);
            ?>

        </div>
    </div>
</body>
</html>
