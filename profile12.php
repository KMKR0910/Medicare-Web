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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="patientDashboard21.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #e3f2fd; /* Light background color */
            font-family: Arial, sans-serif; /* Font style for the body */
        }
        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #fff; /* White background for the container */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Shadow for the container */
        }
        .profile-container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333; /* Dark color for the heading */
        }
        .profile-table {
            width: 100%; /* Make the table take full width */
            border-collapse: collapse; /* Merge borders */
            margin-top: 20px; /* Space above the table */
        }
        .profile-table th, .profile-table td {
            border: 1px solid #ddd; /* Light grey border for cells */
            padding: 15px; /* Add some padding */
            text-align: left; /* Align text to the left */
        }
        .profile-table th {
            background-color: #f2f2f2; /* Light grey background for headers */
            font-weight: bold; /* Bold text for headers */
            color: #333; /* Dark text for headers */
        }
        .profile-table tr:nth-child(even) {
            background-color: #f9f9f9; /* Zebra striping for even rows */
        }
        .profile-table tr:hover {
            background-color: #f1f1f1; /* Highlight row on hover */
        }
        .active {
            background-color: #A4C8E1; /* A different shade for the active item */
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
                        <i class="fas fa-file-prescription"></i>
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
                    <a href="1">
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
            <?php
            // Include MS SQL database connection file
            include "log1.php"; // Update with your MS SQL connection details

            // Check if the user is logged in by verifying the session
            if (isset($_SESSION['user_id'])) {
                // Get the user ID from the session
                $user_id = $_SESSION['user_id'];

                // Prepare the SQL query to fetch user details from MS SQL
                $query = "SELECT [PatientID], [name], [address], [DOB], [gender], [Cno], [email], [password] FROM [dip1].[dbo].[patientSign] WHERE [PatientID] = ?";
                $stmt = sqlsrv_query($conn, $query, array($user_id));

                // Check if the query was successful
                if ($stmt === false) {
                    die('Error executing query: ' . print_r(sqlsrv_errors(), true));
                }

                // Fetch the result
                if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    $user = [
                        'PatientID' => $row['PatientID'],
                        'name' => $row['name'],
                        'address' => $row['address'],
                        'DOB' => $row['DOB'],
                        'gender' => $row['gender'],
                        'Cno' => $row['Cno'],
                        'email' => $row['email'],
                        'password' => $row['password'],
                    ];
                } else {
                    echo "User not found.";
                    exit();
                }

                // Free the statement
                sqlsrv_free_stmt($stmt);
            } else {
                // If user is not logged in, redirect to login page
                header("Location: SuppLog.php");
                exit();
            }

            // Close the database connection
            sqlsrv_close($conn);
            ?>

            <div class="profile-container">
                <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
                <table class="profile-table">
                    <tr>
                        <th>Patient ID</th>
                        <td><?php echo htmlspecialchars($user['PatientID']); ?></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><?php echo htmlspecialchars($user['address']); ?></td>
                    </tr>
                    <tr>
                        <th>DOB</th>
                        <td><?php echo htmlspecialchars($user['DOB']->format('Y-m-d')); ?></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td><?php echo htmlspecialchars($user['gender']); ?></td>
                    </tr>
                    <tr>
                        <th>Contact Number</th>
                        <td><?php echo htmlspecialchars($user['Cno']); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td><?php echo htmlspecialchars($user['password']); ?></td>
                    </tr>
                </table>
                <form method="POST" action="downloadProfile.php">
                    <!-- Hidden fields with user data -->
                    <input type="hidden" name="PatientID" value="<?php echo htmlspecialchars($user['PatientID']); ?>">
                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($user['name']); ?>">
                    <input type="hidden" name="address" value="<?php echo htmlspecialchars($user['address']); ?>">
                    <input type="hidden" name="DOB" value="<?php echo htmlspecialchars($user['DOB']->format('Y-m-d')); ?>">
                    <input type="hidden" name="gender" value="<?php echo htmlspecialchars($user['gender']); ?>">
                    <input type="hidden" name="Cno" value="<?php echo htmlspecialchars($user['Cno']); ?>">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                    <input type="hidden" name="password" value="<?php echo htmlspecialchars($user['password']); ?>">
                    <button type="submit">Download Profile</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
