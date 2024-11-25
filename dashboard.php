<?php
// Start session
session_start();

// Include database connection
require_once 'connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Fetch the list of users (admins) except the logged-in user
$query = "SELECT id, username FROM accounts WHERE username != :username";
$stmt = $pdo->prepare($query);
$stmt->execute(['username' => $_SESSION['user']]);
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

// If a chat partner is selected
$chat_with = isset($_GET['chat_with']) ? $_GET['chat_with'] : null;
$chat_with_name = null;
$messages = [];

// Fetch chat messages if a chat partner is selected
if ($chat_with) {
    // Fetch the name of the user being chatted with
    $stmt = $pdo->prepare("SELECT username FROM accounts WHERE id = :id");
    $stmt->execute(['id' => $chat_with]);
    $chat_with_name = $stmt->fetchColumn();

    // Fetch the chat messages between the logged-in user and the selected user
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Dashboard</title>

    <script>
        // Function to set and activate the desired section based on navigation clicks
        function setActiveSection(sectionId) {
            window.location.hash = sectionId;  
            toggleSection(sectionId); // Toggle visibility of the selected section
            setActiveLink(sectionId); // Update active link in sidebar
        }

        // Function to toggle visibility of sections
        function toggleSection(sectionId) {
            var sections = document.querySelectorAll('.section');
            sections.forEach(function(section) {
                if (section.id === sectionId) {
                    section.style.display = 'block'; // Show the active section
                } else {
                    section.style.display = 'none'; // Hide other sections
                }
            });
        }

        // Function to highlight the active link
        function setActiveLink(sectionId) {
            var links = document.querySelectorAll('.sidebar a');
            links.forEach(function(link) {
                link.classList.remove('active');
                if (link.getAttribute('href').includes(sectionId)) {
                    link.classList.add('active');
                }
            });
        }

        // Show default section (e.g., HOME) when page loads
        document.addEventListener('DOMContentLoaded', function () {
            var hash = window.location.hash.substring(1);
            if (!hash) hash = 'chats'; // Default to home section if no hash in URL
            toggleSection(hash); // Toggle based on hash (default is 'home')
            setActiveLink(hash); // Set active link based on hash
        })
    </script>
</head>
<body>

    <!-- Sidebar (Navigation links) -->
    <div class="sidebar">
        <h3>Dashboard</h3>
        <ul>
            <li><a href="#chats" onclick="setActiveSection('chats')">Chats</a></li>
            <li><a href="#guidance" onclick="setActiveSection('guidance'); loadGuidanceSystem();">Guidance</a></li>
        </ul>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <!-- Main Content (Dynamic Sections) -->
    <div class="main-content">
      
        <!-- Chats Section -->
        <div id="chats" class="section" style="display: none;">
            <?php include 'CHATS/chats.php'; ?>
        </div>

        <!-- Guidance Section -->
        <div id="guidance" class="section" style="display: none;">
            <!-- Guidance system embedded as an iframe -->
            <iframe src="" width="100%" height="600px" frameborder="0" id="guidance-iframe"></iframe>
        </div>

    </div>

    <script>
        function loadGuidanceSystem() {
            var guidanceIframe = document.getElementById('guidance-iframe');
            guidanceIframe.src = 'http://localhost/gscdd/dashboard.php'; // Set the URL of your guidance system here
        }
    </script>
</body>
</html>
