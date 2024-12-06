<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Details</title>
    <link rel="stylesheet" type="text/css" href="style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="appointments-container">
        <h1>Your Appointments</h1>

        <?php if (isset($error_message)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
        <?php else: ?>
            <?php if (count($appointments) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Appointment Number</th>
                            <th>Patient Name</th>
                            <th>Contact Number</th>
                            <th>Appointment Date</th>
                            <th>Appointment Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $appointment): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($appointment['app_num']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['conta']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['app_date']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['app_time']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No appointments available.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
