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

// Get the selected chat partner (receiver)
$chat_with = isset($_GET['chat_with']) ? $_GET['chat_with'] : null;
if (!$chat_with) {
    echo json_encode(['error' => 'No chat partner selected']);
    exit();
}

// Fetch messages between the logged-in user and the selected user
$stmt = $pdo->prepare("
    SELECT m.id, m.message, m.created_at, u.username AS sender_name
    FROM messages m
    JOIN accounts u ON m.sender_id = u.id
    WHERE (m.sender_id = :user_id AND m.receiver_id = :chat_with)
    OR (m.sender_id = :chat_with AND m.receiver_id = :user_id)
    ORDER BY m.created_at ASC
");
$stmt->execute([
    'user_id' => $_SESSION['user_id'],
    'chat_with' => $chat_with
]);

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return messages as JSON
echo json_encode($messages);
?>
