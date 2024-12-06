<?php
session_start();

// Check if the user is logged in and retrieve Fname from the session
if (isset($_SESSION['Fname'])) {
    $Fname = $_SESSION['Fname'];
} else {
    // Redirect to login if the user is not logged in
    header("Location: SuppLog.php");
    exit();
}
?>

<html>
    <head>
    <link rel="stylesheet" href="patientDashboard21.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <div class="sidebar">
            <div class="logo">
                <ul class="menu">
                    <li class="active">
                        <a href="dashboardS.php" >
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                    <a href="profileP.php">
                       
                            <i class="fas fa-user-alt"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li>
                    <a href="Stat.php">
                            <i class="fas fa-chart-bar"></i>
                            <span>Statistics</span>
                        </a>
                    </li>
                    <li class="logout">
                        <a href="logoutP.php">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Log out</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main--content">
            <div class="header--wrapper">
                <div class="header--title">
                    <h1>Welcome, <?php echo htmlspecialchars($Fname); ?>!</h1>
                    <h2>Dashboard</h2>
                </div>
                <div class="user--info">
                    <div class="search--box">
                        <i class="fa-solid fa-search"></i>
                    </div>
                    <img src="s1.jpg" alt="User Image">
                </div>
            </div>

            <div class="fieldset1">
                <fieldset class="b1">
                    <div class="booking">
                        <h3>Create new drug order price list</h3>
                        <img src="dr1.jpg" class="app1" alt="Drug Order"><br>
                        <h3><a href="list.html" class="b11">Create list</a></h3>
                    </div>
                </fieldset><br><br>

                <fieldset class="b2">
                    <div class="booking2">
                        <h3>Edit your Drug list!</h3>
                        <img src="dr2.jpg" class="app1" alt="Appointment"><br>
                        <h3><a href="editP1.php" class="b11">Edit Appointment</a></h3>
                    </div>
                </fieldset>

                <fieldset class="b2">
                    <div class="booking">
                        <h3>Delete your Drug order!</h3>
                        <img src="dr3.jpg" class="app1" alt="Appointment"><br>
                        <h3><a href="deleteS.php" class="b11">Delete Appointment</a></h3>
                    </div>
                </fieldset>
            </div>
        </div>
    </body>
</html>
