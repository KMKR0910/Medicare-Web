<?php
session_start();

// Include database connection file
include "log1.php"; // Update with your MS SQL connection details

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Get the selected date from the date picker
   

    // SQL query to get prescriptions for the selected date and patient ID
    $query = "SELECT [Lab_Report_ID], [Test_Type],[Rep_status], [Blood_Collected_Time], [Report_Relesed_Time]
              FROM [tbl_Lab_Test_Report]
              [Patient_ID] = ?";
    $stmt = sqlsrv_query($conn, $query, array($user_id));

    if ($stmt === false) {
        die('Error executing query: ' . print_r(sqlsrv_errors(), true));
    }

    // Display prescriptions in a table
    echo '<form method="POST" action="">';
    echo '<table class="profile-table">';
    echo '<tr><th>Test Type</th><th>Test Price</th><th>Status</th><th>Blood Collected Date</th><th>Report Relesed Date</th></tr>';

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['[Test_Type]']) . '</td>';
        echo '<td>' . htmlspecialchars($row['[Test_Price]']) . '</td>';
        echo '<td>' . htmlspecialchars($row['[Rep_status]']) . '</td>';
        echo '<td>' . htmlspecialchars($row['[Blood_Collected_Time]']) . '</td>';
        echo '<td>' . htmlspecialchars($row['[Report_Relesed_Time]']->format('Y-m-d')) . '</td>';
        echo '</tr>';
    }

    echo '</table>';

       // Add Download and Print buttons
       echo '<div style="margin-top: 20px;">';
       echo '<button type="submit" name="download" class="btn">Download Report</button>';
       echo '<button type="submit" name="print" class="btn">Print Report</button>';
       echo '</div>';
       echo '</form>';

    // Free the statement and close the connection
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
} else {
    // If user is not logged in, redirect to login page
    header("Location: SuppLog.php");
    exit();
}
?>
