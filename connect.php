<?php
// Database connection details
$host = '127.0.0.1'; // Your database host
$dbname = 'asecec'; // Your database name
$user = 'root'; // Your database username
$pass = '12345'; // Your database password

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
