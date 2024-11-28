<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Health";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$uid = $_POST['uid'];
$name = $_POST['name'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$uhid = $_POST['uhid'];
$blood_group = $_POST['blood_group'];
$prescription_link = $_POST['prescription_link'];
$medication_link = $_POST['medication_link'];

// Insert data into the database
$sql = "INSERT INTO patients (uid, name, age, gender, uhid, blood_group, prescription_link, medication_link) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssisssss", $uid, $name, $age, $gender, $uhid, $blood_group, $prescription_link, $medication_link);


$stmt->close();
$conn->close();
