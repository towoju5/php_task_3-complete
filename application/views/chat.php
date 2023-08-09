<!DOCTYPE html>
<html>

<head>
    <title>Long Polling Chat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        Chat
                    </div>
                    <div class="card-body">
                        <div class="chat-box" id="all_messages">
                            <!-- Messages will be displayed here -->
                        </div>
                    </div>
                    <form name="publish">
                    <div class="card-footer">
                        <div class="input-group">
                                <input type="text" class="form-control" autocomplete="off" id="message" placeholder="Type a message...">
                                <input type="submit" value="Send" class="btn btn-primary" id="send">
                                <!-- <div class="input-group-append">
                                    <button class="btn btn-primary" id="send">Send</button>
                                </div> -->
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        new sendChat(document.forms.publish, 'publish');
        new getChats(document.getElementById('all_messages'), 'subscribe');

        // Sending messages, a simple POST
        function sendChat(form, url) {
            function sendMessage(message) {
                $.post(url, {
                    message: message
                });
            }

            form.onsubmit = function() {
                let message = form.message.value;
                if (message) {
                    form.message.value = '';
                    sendMessage(message);
                }
                return false;
            };
        }

        // Receiving messages with long polling
        function getChats(elem, url) {

            function showMessage(incoming) {
                $("#all_messages").empty();
                messages = JSON.parse(incoming)
                var allMessagesElement = document.getElementById("all_messages");
                messages.forEach(function(message) {
                    var messageElement = document.createElement("div");
                    messageElement.textContent = message.chat_messages;
                    allMessagesElement.appendChild(messageElement);
                });
            }

            async function subscribe() {
                let response = await fetch(url);

                if (response.status == 502) {
                    // Connection timeout
                    // happens when the connection was pending for too long
                    // let's reconnect
                    await subscribe();
                } else if (response.status != 200) {
                    // Show Error
                    showMessage(response.statusText);
                    // Reconnect in one second
                    await new Promise(resolve => setTimeout(resolve, 1000));
                    await subscribe();
                } else {
                    // Got message
                    let message = await response.text();
                    showMessage(message);
                    await subscribe();
                }
            }

            subscribe();

        }
    </script>
</body>

</html>