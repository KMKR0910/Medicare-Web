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
    <link rel="stylesheet" type="text/css" href="footer.css">
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

<script>
        // Keep the session alive every 10 minutes (600000 milliseconds)
        setInterval(function() {
            fetch('keep_session_alive.php'); // Call the PHP script to keep session alive
        }, 600000);
    </script>
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
                <h2>Prescription Dashboard</h2>
            </div>
        </div>

        <div class="fieldsets">
            <div class="profile-container">
            <div class="container">

<form method="post" action="">
<label for="appointment_date">Select Date:</label>
<input type="date" id="appointment_date" name="appointment_date" required>
<button type="submit" name="check-Avaliability">Check Availability</button>
</form>
    
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include "log1.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Check if booking button is clicked
if (isset($_POST["check-Avaliability"])) {


$selectedDate = $_POST["appointment_date"];





// Query to check for the appointment date and retrieve appointment number
$sql = "SELECT TOP 1 [AppointmentNumber], [StartTime],[SessionID],[SessionDate]
        FROM [DoctorSessions]
        WHERE CAST([SessionDate] AS DATE) = ? AND [AppointmentStatus] = 'Avaliable'
        ORDER BY [StartTime] ASC";
$params = [$selectedDate];

$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
die(print_r(sqlsrv_errors(), true));
}

// Fetch results
$appointments = [];

// Fetch results and store them in the appointments array
while ($appointment = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
$appointments[] = $appointment;
}




$_SESSION['appointments'] = $appointments;

sqlsrv_free_stmt($stmt);

}}
?>



<?php if (isset($appointments)) { ?>
<h3>Appointments on <?php echo htmlspecialchars($selectedDate); ?>:</h3>
<?php if (empty($appointments)) { ?>
    <p>No appointments available.</p>
<?php } else { ?>
    <p>Doctor available.</p>
    
    <table class="profile-table">
    <tr>
        <th>Appointment Number</th>
        <th>Start Time</th>
        <th>Session ID</th>
        <th>Session Date</th>
    </tr>
    <?php foreach ($appointments as $appointment) { ?>
        <tr>
        <td><?php echo htmlspecialchars($appointment['AppointmentNumber']); ?></td>
        <td><?php echo htmlspecialchars($appointment['StartTime']->format('Y-m-d H:i:s')); ?></td> <!-- Format StartTime -->
        <td><?php echo htmlspecialchars($appointment['SessionID']); ?></td>
        <td><?php echo htmlspecialchars($appointment['SessionDate']->format('Y-m-d H:i:s')); ?></td>
        </tr>
    <?php } ?>
</table>
    


</form>

<?php } ?>
<?php } ?>


<form method="POST" action="">
    <input type="hidden" name="appointment_ID" value="<?php echo htmlspecialchars($sessionID); ?>">
<button type="submit" name="book_appointment">Book a number </button></form>
<?php




if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Check if booking button is clicked
if (isset($_POST["book_appointment"])) {
// Get the appointment number
//$appointmentID = $_POST["appointment_ID"];
if (!empty($_SESSION['appointments'])) {
    $appointments = $_SESSION['appointments'];
    $appointmentNumber = $appointments[0]['AppointmentNumber'];
    $startTime = $appointments[0]['StartTime'];
    $sessionID = $appointments[0]['SessionID'];
    $sessionDate = $appointments[0]['SessionDate'];
    
}
$pID = $_SESSION['user_id'];
include "log1.php";

// Prepare the booking query

// Assuming you have a table for booked appointments (e.g., "BookedAppointments") and want to store the appointment number and booking details.
if ($sessionDate && $startTime && $appointmentNumber) {
$sql = "INSERT INTO [tbl_appoinment] ([Date], [time],[Appoinment Number],[status],[Patient ID]) VALUES (?,?,?,'Pending',?)";
$params = [$sessionDate,$startTime,$appointmentNumber,$pID];

// Execute the query
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die("Query execution failed: " . print_r(sqlsrv_errors(), true));

}
sqlsrv_free_stmt($stmt);
echo "<p>Appointment booked successfully!</p>";
}else   {
echo "<p>Error: Missing appointment details.</p>";
}

sqlsrv_close($conn);

// Redirect or show success message after booking

}
}
?>
                
                   

        
            </div>
            </div>
</body>

<footer>
<div class="footer-container">
    <div class="footer-section links">
        <h3>Our socials</h3>        <a href=""><i class="fa-brands fa-facebook"></i></a>
        <a href=""><i class="fa-brands fa-instagram"></i></a>
        <a href=""><i class="fa-brands fa-linkedin"></i></a><br>
        
    </div>
    <div class="footer-section address">
        <h3>Our Address</h3>
        <p>Kurusa Road<br>Panadura, Sri Lanka</p>
      </div>
      <div class="footer-section map">
        <h3>Our Location</h3>
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8354345093715!2d144.9556513153167!3d-37.81732797975159!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0x5045675218ce7e33!2sMelbourne%20VIC%2C%20Australia!5e0!3m2!1sen!2sau!4v1602749646489!5m2!1sen!2sau"
          width="100%" height="200" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
      </div>
    </div>
    <p>Copyright &copy;2024; Designed by xxxx</p>

</footer>
</html>
