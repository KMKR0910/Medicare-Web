<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['name'])) {
    $userName = $_SESSION['name'];
    $supplierID = $_SESSION['user_id']; // Assuming the supplier ID is stored in session
} else {
    $userName = "Guest"; // Default if not logged in
    $supplierID = null;  // Default if not logged in
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Order History</title>
    <link rel="stylesheet" href="patientDashboard21.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        .order-history-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            padding: 20px;
            margin-top: 30px;
        }

        .order-history-container h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .order-history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .order-history-table th, .order-history-table td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
        }

        .order-history-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }

        .order-history-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .order-history-table tr:hover {
            background-color: #f1f1f1;
        }

        .order-history-table .order-item {
            font-weight: bold;
            color: #00796b;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="order-history-container">
            <h1>Order History for <?php echo htmlspecialchars($userName); ?>!</h1>
            
            <?php
            // Include MS SQL database connection file
            include "log1.php"; // Update with your MS SQL connection details

            // Check if the user is logged in by verifying the session
            if ($supplierID) {
                // Prepare the SQL query to fetch the order history for the logged-in supplier
                $query = "SELECT TOP (1000) [Item_ID], [Drug_Name], [Pack_Size], [Quantity], [supplier_ID] FROM [dip1].[dbo].[DrugOrderItem] WHERE [supplier_ID] = ?";
                $stmt = sqlsrv_query($conn, $query, array($supplierID));

                // Check if the query was successful
                if ($stmt === false) {
                    die('Error executing query: ' . print_r(sqlsrv_errors(), true));
                }

                // Display the results in a table
                echo '<table class="order-history-table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Item ID</th>';
                echo '<th>Drug Name</th>';
                echo '<th>Pack Size</th>';
                echo '<th>Quantity</th>';
                echo '<th>Supplier ID</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                // Loop through the result set and display each order item
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['Item_ID']) . '</td>';
                    echo '<td class="order-item">' . htmlspecialchars($row['Drug_Name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['Pack_Size']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['Quantity']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['supplier_ID']) . '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
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
</body>
</html>
