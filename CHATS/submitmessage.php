<?php
// Start session
session_start();

// Include database connection
require_once '../connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

// Check if message and receiver are set
if (isset($_POST['message']) && isset($_POST['receiver'])) {
    $message = $_POST['message'];
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver'];

    // Insert the message into the database
    $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (:sender_id, :receiver_id, :message)");
    $stmt->execute([
        'sender_id' => $sender_id,
        'receiver_id' => $receiver_id,
        'message' => $message
    ]);

    // Respond with success
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['error' => 'Message or receiver not set']);
}
?>
