<?php
// Establish database connection
$conn = mysqli_connect('localhost', 'root', '', 'hms_db');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create table
$sql = "CREATE TABLE IF NOT EXISTS tbl_appointments (
    id INT AUTO_INCREMENT,
    patient_name VARCHAR(255),
    department VARCHAR(255),
    doctor VARCHAR(255),
    date DATE,
    time TIME,
    message TEXT,
    PRIMARY KEY (id)
)";

if (mysqli_query($conn, $sql)) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
?>