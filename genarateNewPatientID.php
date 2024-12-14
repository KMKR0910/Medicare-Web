<?php
function generateNewPatientID() {
    include "log1.php";

    // Connect to the database using PDO
    try {
      
        // Query to get the last Patient ID
        $query = "SELECT TOP 1 [Patient ID] FROM [tbl_patient_info] ORDER BY [Patient ID] DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $lastUserID = null;

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $lastUserID = $row['Patient ID'];
        }

        // Generate the new Patient ID
        if (empty($lastUserID)) {
            $newPatientID = "P00001";
        } else {
            $numericPart = substr($lastUserID, 1); // Extract the numeric part
            $newNumericPart = (int)$numericPart + 1; // Increment the numeric part
            $newPatientID = "P" . str_pad($newNumericPart, 5, "0", STR_PAD_LEFT); // Add leading zeros
        }

        return $newPatientID;
    } catch (PDOException $e) {
        // Handle the database connection error
        echo "Database connection failed: " . $e->getMessage();
        return null;
    }
}

// Usage example
$newID = generateNewPatientID();
if ($newID) {
    echo "New Patient ID: " . $newID;
}
?>
