<?php
session_start();

// Check if the user is logged in and retrieve Supplier_ID from the session
if (isset($_SESSION['Supplier_ID'])) {
    $supplierID = $_SESSION['Supplier_ID'];
} else {
    // Redirect to login if the user is not logged in
    header("Location: SuppLog.php");
    exit();
}

// Include the database connection file
include "log1.php"; // Ensure this file establishes a connection to your MS SQL Server

// Fetch the supplier data from the database
$sql = "SELECT Supplier_ID, Fname, Lname, Company_name, Address, Email_Address FROM DrugSupplier WHERE Supplier_ID = ?";
$params = array($supplierID);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    echo "Error fetching data from database.";
    exit();
}

// Fetch the supplier's data
$supplierData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

// Close the statement and database connection
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="patientDashboard21.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        .main--content {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        .profile-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 70%;
            padding: 20px;
            margin-top: 30px;
            text-align: center;
        }

        .profile-container h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        .profile-container h3 {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f4f4f4;
        }

        table td {
            background-color: #fafafa;
        }

        .profile-container img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .download-btn {
            display: inline-block;
            background-color: #00796b;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
        }

        .download-btn:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body>
<div class="sidebar">
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
    </div>

    <div class="main--content">
        <div class="profile-container">
            <h1>Welcome, <?php echo htmlspecialchars($supplierData['Fname']); ?>!</h1>
            <h3>Your Profile Information</h3>
            <img src="s1.jpg" alt="User Image">
            <table>
                <tr>
                    <th>Supplier ID</th>
                    <td><?php echo htmlspecialchars($supplierData['Supplier_ID']); ?></td>
                </tr>
                <tr>
                    <th>First Name</th>
                    <td><?php echo htmlspecialchars($supplierData['Fname']); ?></td>
                </tr>
                <tr>
                    <th>Last Name</th>
                    <td><?php echo htmlspecialchars($supplierData['Lname']); ?></td>
                </tr>
                <tr>
                    <th>Company Name</th>
                    <td><?php echo htmlspecialchars($supplierData['Company_name']); ?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?php echo htmlspecialchars($supplierData['Address']); ?></td>
                </tr>
                <tr>
                    <th>Email Address</th>
                    <td><?php echo htmlspecialchars($supplierData['Email_Address']); ?></td>
                </tr>
            </table>
            <form method="POST" action="downloadProfile.php">
                <input type="hidden" name="Supplier_ID" value="<?php echo htmlspecialchars($supplierData['Supplier_ID']); ?>">
                <input type="hidden" name="Fname" value="<?php echo htmlspecialchars($supplierData['Fname']); ?>">
                <input type="hidden" name="Lname" value="<?php echo htmlspecialchars($supplierData['Lname']); ?>">
                <input type="hidden" name="Company_name" value="<?php echo htmlspecialchars($supplierData['Company_name']); ?>">
                <input type="hidden" name="Address" value="<?php echo htmlspecialchars($supplierData['Address']); ?>">
                <input type="hidden" name="Email_Address" value="<?php echo htmlspecialchars($supplierData['Email_Address']); ?>">
                <button type="submit" class="download-btn">Download Profile</button>
            </form>
        </div>
    </div>
</body>
</html>
