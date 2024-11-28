<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Health";

// Initialize variables
$patient = null;
$uid_from_rfid = ""; // This will be dynamically populated with RFID UID

// Check if UID is available from the RFID scan (this will be populated from the RFID hardware)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid_from_rfid = $_POST['uid']; // Assume the UID is being sent as a POST request (from the RFID reader)

    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch patient data based on UID
    $sql = "SELECT * FROM patients WHERE uid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uid_from_rfid); // Bind the UID from RFID to the query
    $stmt->execute();
    $result = $stmt->get_result();

    // If a matching patient is found, store the data
    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
    } else {
        $patient = null; // No patient found
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Patient Dashboard</h1>

        <!-- Form to input UID (RFID UID input for users) -->
        <form action="index.php" method="post">
            <label for="uid">Enter UID (RFID):</label>
            <input type="text" id="uid" name="uid" required>
            <button type="submit">Search</button>
        </form>

        <?php if ($patient): ?>
            <!-- Display patient details if a match is found -->
            <h2>Patient Information</h2>
            <p><strong>Name:</strong> <?php echo $patient['name']; ?></p>
            <p><strong>Age:</strong> <?php echo $patient['age']; ?></p>
            <p><strong>Gender:</strong> <?php echo $patient['gender']; ?></p>
            <p><strong>UHID:</strong> <?php echo $patient['uhid']; ?></p>
            <p><strong>Blood Group:</strong> <?php echo $patient['blood_group']; ?></p>

            <!-- Buttons to view prescription and medications -->
            <button class="btn-prescription" onclick="window.open('<?php echo $patient['prescription_link']; ?>')">View Prescription</button>
            <button class="btn-medication" onclick="window.open('<?php echo $patient['medication_link']; ?>')">View Medications</button>
        <?php else: ?>
            <!-- Display message if no matching patient is found -->
            <p>No patient data found for the provided UID.</p>
        <?php endif; ?>
    </div>
</body>

</html>