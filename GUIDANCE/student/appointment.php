<?php
// Establish database connection
$conn = mysqli_connect('localhost', 'root', '', 'hms_db');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Validate and sanitize form data
$patient_name = mysqli_real_escape_string($conn, $_POST['patient_name']);
$department = mysqli_real_escape_string($conn, $_POST['department']);
$doctor = mysqli_real_escape_string($conn, $_POST['doctor']);
$date = mysqli_real_escape_string($conn, $_POST['date']);
$time = mysqli_real_escape_string($conn, $_POST['time']);
$message = mysqli_real_escape_string($conn, $_POST['message']);

// Prepare SQL query
$stmt = mysqli_prepare($conn, "INSERT INTO tbl_appointment (patient_name, department, doctor, date, time, message) VALUES (?, ?, ?, ?, ?, ?)");

// Bind parameters
mysqli_stmt_bind_param($stmt, "ssssss", $patient_name, $department, $doctor, $date, $time, $message);

// Execute SQL query
mysqli_stmt_execute($stmt);

// Close statement
mysqli_stmt_close($stmt);

// Close database connection
mysqli_close($conn);

// Redirect to dashboard
header('Location: dashboard.php');
exit;
?>