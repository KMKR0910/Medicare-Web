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
    <title>Prescription Data</title>
    <link rel="stylesheet" href="patientDashboard21.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Your CSS styles here */
        body {
            background-color: #e3f2fd;
            font-family: Arial, sans-serif;
        }
        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .profile-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .profile-table th, .profile-table td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
        }
        .profile-table th {
            background-color: #f2f2f2;
        }
        .profile-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .profile-table tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="sidebar">
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
                    <a href="prescripton.php">
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
                    <a href="diagnose.php">
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

    </div>

    <div class="main--content">
        <div class="header--wrapper">
            <div class="header--title">
                <h1><?php echo htmlspecialchars($userName); ?>!</h1>
                <h2>Appoinment Book</h2>
            </div>
        </div>

        <div class="fieldsets">
            <div class="profile-container">
                <h1>Prescriptions</h1>

                <!-- Date Picker -->
                <label for="datePicker">Select Date:</label>
                <input type="date" id="datePicker" name="date" value="<?php echo date('Y-m-d'); ?>">

                <?php
                // Include database connection file
                include "log1.php"; // Update with your MS SQL connection details

                // Check if the user is logged in
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];

                    // Get the selected date from the date picker
                    if (isset($_POST['date'])) {
                        $selectedDate = $_POST['date'];
                    } else {
                        $selectedDate = date('Y-m-d'); // Default to today's date
                    }

                    // SQL query to get prescriptions for the selected date and patient ID
                    $query = "SELECT TOP 1 [AppointmentNumber], [StartTime],[SessionDate]
                FROM [DoctorSessions]
                WHERE CAST([SessionDate] AS DATE) = ? AND [AppointmentStatus] = 'Avaliable'
                ORDER BY [StartTime] ASC";
                    $stmt = sqlsrv_query($conn, $query, array($selectedDate, $user_id));

                    if ($stmt === false) {
                        die('Error executing query: ' . print_r(sqlsrv_errors(), true));
                    }

                    // Display prescriptions
                    echo '<table class="profile-table">';
                    echo '<tr><th>Appoinmet Number</th><th>Time</th><th>Date</th></tr>';

                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['AppointmentNumber']) . '</td>';
                        
                        echo '<td>' . htmlspecialchars($row['StartTime']->format('H:i:s')) . '</td>'; // Format StartTime to string                      
                        echo '<td>' . htmlspecialchars($row['SessionDate']->format('Y-m-d')) . '</td>';
                        echo '</tr>';
                    }

                    echo '</table>';

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
            </div>
        </div>
    </div>

    <script>
        // JavaScript to handle date picker change
        document.getElementById("datePicker").addEventListener("change", function() {
            let selectedDate = this.value;
            let formData = new FormData();
            formData.append('date', selectedDate);

            fetch('your_php_file.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.querySelector('.profile-container').innerHTML = data;
            });
        });
    </script>

</body>
</html>
