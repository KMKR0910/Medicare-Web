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
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="patientDashboard21.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .active {
            background-color: #A4C8E1; /* Highlight for active menu item */
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
                    <a href="PatientD3.php">
                        <i class="fas fa-file-prescription"></i>
                        <span>Prescription</span>
                    </a>
                </li>
                <li>
                    <a href="PatientD3.php">
                        <i class="fas fa-vial"></i>
                        <span>Lab Results</span>
                    </a>
                </li>
                <li>
                    <a href="PatientD3.php">
                        <i class="fas fa-history"></i>
                        <span>Diagnosis History</span>
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
                <h1>Welcome, <?php echo htmlspecialchars($userName); ?>!</h1> <!-- Use htmlspecialchars for security -->
                <h2>Dashboard</h2>
            </div>
        </div>

        <div class="fieldset1">
            <!-- Appointment Booking Section -->
            <fieldset class="b1">
                <div class="booking">
                    <h3>Book Your Appointment!</h3>
                    <img src="doc2.png" class="app1" alt="Appointment">
                    <h3><a href="book21.html" class="b11">Book Appointment</a></h3>
                </div>
            </fieldset>

            <!-- Edit Appointment Section -->
            <fieldset class="b2">
                <div class="booking2">
                    <h3>Edit Your Appointment!</h3>
                    <img src="cal.jpg" class="app1" alt="Appointment">
                    <h3><a href="dashboardP3.php" class="b11">Edit Appointment</a></h3>
                </div>
            </fieldset>

            <!-- Delete Appointment Section -->
            <fieldset class="b2">
                <div class="booking">
                    <h3>Delete Your Appointment!</h3>
                    <img src="cal2.jpg" class="app1" alt="Appointment">
                    <h3><a href="delete1.php" class="b11">Delete Appointment</a></h3>
                </div>
            </fieldset>

        </div>

        <!-- Appointment Information Section -->
        <fieldset class="confirm">
            <h1 class="head"><u>Appointment Information</u></h1>
            <!-- Message and details will be displayed here -->
            <div id="message"></div>
            <div id="details"></div>
        </fieldset>

    </div>

    <!-- JavaScript for handling appointment details -->
    <script>
        // Function to get query parameters from URL
        function getQueryParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // Get appointment details from query parameters
        const apID = getQueryParameter('apID'); 
        const patientName = getQueryParameter('name');
        const contact = getQueryParameter('contact');
        const date = getQueryParameter('date');
        const time = getQueryParameter('time');

        if (apID) {
            document.getElementById('message').textContent = "Your appointment number is: " + apID;
        }

        if (patientName && contact && date && time) {
            document.getElementById('details').innerHTML = `
                <p><strong>Patient Name:</strong> ${patientName}</p>
                <p><strong>Contact Number:</strong> ${contact}</p>
                <p><strong>Appointment Date:</strong> ${date}</p>
                <p><strong>Appointment Time:</strong> ${time}</p>`;
        }

        // Handle error message from query parameters
        const errorMessage = getQueryParameter('error_message');
        if (errorMessage) {
            document.getElementById('message').textContent = errorMessage;
        }
    </script>

</body>
</html>
