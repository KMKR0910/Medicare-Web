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
        <link rel="stylesheet" href="slog2.css"> 
        <link rel="stylesheet" href="style.css"> 
        <script src="logout-confirmation.js"></script>

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
                    <a href="activity.php">
                            <i class="fas fa-chart-bar"></i>
                            <span>Statistics</span>
                        </a>
                    </li>
                    <li class="logout">
                        <a href="logoutP.php"><?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['supp_id'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the homepage or login page
    header("Location: homepg.html");
    exit();
} else {
    // If the user is not logged in, redirect to the homepage
    header("Location: homepg.html");
    exit();
}
?>

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
 
?>


        </div>
    </body>
</html>
