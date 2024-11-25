<section>
    <div class="chat-container">
        <!-- Chat List on the Left -->
        <div class="chat-list-container">
            <h3>Select a Chat Partner</h3>
            <?php if ($admins): ?>
                <ul>
                    <?php foreach ($admins as $admin): ?>
                        <li>
                            <a href="javascript:void(0);" class="chat-link" data-id="<?php echo $admin['id']; ?>">Chat with <?php echo htmlspecialchars($admin['username']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No admins available for chat.</p>
            <?php endif; ?>
        </div>

        <!-- Chat Box on the Right -->
        <div class="chat-box-container" id="chat-box-container" style="width: 65%; float: left;">
            <?php if ($chat_with): ?>
                <div class="chat-box">
                    <h3>Chat with <?php echo htmlspecialchars($chat_with_name); ?></h3>
                    <div class="messages">
                        <?php foreach ($messages as $msg): ?>
                            <div class="message <?php echo $msg['sender_name'] == $_SESSION['user'] ? 'sent' : 'received'; ?>">
                                <strong><?php echo htmlspecialchars($msg['sender_name']); ?>:</strong>
                                <?php echo htmlspecialchars($msg['message']); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Chat Input -->
                    <form method="post" class="chat-input" id="chat-form">
                        <input type="hidden" name="receiver" value="<?php echo htmlspecialchars($chat_with); ?>">
                        <textarea name="message" placeholder="Type your message here..." rows="3" required></textarea>
                        <button type="submit">Send</button>
                    </form>
                </div>
            <?php else: ?>
                <p>Please select an admin to chat with.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- AJAX & JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Store the current chat partner ID
        var currentChatWith = '<?php echo $chat_with ?: ($admins ? $admins[0]['id'] : ''); ?>'; // Default to first admin if no chat selected

        // Automatically click the first chat partner in the list if not already selected
        if (currentChatWith && $('.chat-link').length > 0) {
            // Find the first chat link and simulate a click
            $('.chat-link').first().click();
        }

        // Function to fetch messages
        function fetchMessages(chatWith) {
            if (!chatWith) {
                return; // No chat selected, do nothing
            }

            $.ajax({
                url: 'CHATS/fetchmessage.php',
                type: 'GET',
                data: { chat_with: chatWith },
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        console.log(response.error);
                        return;
                    }

                    // Clear existing messages
                    $('.messages').empty();

                    // Append new messages
                    response.forEach(function(msg) {
                        var messageClass = (msg.sender_name == '<?php echo $_SESSION['user']; ?>') ? 'sent' : 'received';
                        var messageHTML = '<div class="message ' + messageClass + '"><strong>' + msg.sender_name + ':</strong> ' + msg.message + '</div>';
                        $('.messages').append(messageHTML);
                    });

                    // Scroll to the bottom of the messages
                    $('.messages').scrollTop($('.messages')[0].scrollHeight);
                },
                error: function() {
                    console.log('Error fetching messages');
                }
            });
        }

        // Handle click event for each chat partner in the list
        $('.chat-link').click(function() {
            var chatWithId = $(this).data('id'); // Get the selected chat partner ID
            
            // Update the URL without reloading the page
            history.pushState(null, '', 'dashboard.php?chat_with=' + chatWithId);

            // Update the current chat partner ID
            currentChatWith = chatWithId;

            // Fetch messages for the selected user
            fetchMessages(currentChatWith); // Pass the selected chat partner ID to fetch messages
        });

        // Handle message submission
        $('#chat-form').on('submit', function(e) {
            e.preventDefault();
            
            var message = $('textarea[name="message"]').val();
            if (message.trim() === '') return;

            $.ajax({
                url: 'CHATS/submitmessage.php',
                type: 'POST',
                data: {
                    message: message,
                    receiver: currentChatWith
                },
                success: function() {
                    // Clear input and refresh messages
                    $('textarea[name="message"]').val('');
                    fetchMessages(currentChatWith); // Update the messages immediately after sending
                },
                error: function() {
                    console.log('Error submitting message');
                }
            });
        });

        // Periodically fetch messages (every 2 seconds)
        setInterval(function() {
            if (currentChatWith) {
                fetchMessages(currentChatWith); // Fetch messages only for the current chat partner
            }
        }, 2000);

        // Initial call to load messages if a chat partner is selected
        if (currentChatWith) {
            fetchMessages(currentChatWith);
        }
    });
</script>

