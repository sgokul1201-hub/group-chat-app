<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Group Chat</title>
<style>
/* General body */
body {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background: #ece5dd;
    margin: 0;
    padding: 0;
    height: 100vh;
    display: flex;
    flex-direction: column;
}

/* 🔹 Custom Header */
.chat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 20px;
    background: linear-gradient(90deg, #075e54, #128c7e);
    color: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

/* Left side - Logo + Title */
.chat-header .title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 18px;
    font-weight: bold;
}

.chat-header .title .logo {
    font-size: 20px;
}

/* Right side - User + Logout */
.chat-header .user-section {
    display: flex;
    align-items: center;
    gap: 15px;
}

.chat-header .welcome {
    font-size: 14px;
    font-weight: 500;
}

.chat-header .logout-btn {
    background: #ff4d4d;
    padding: 6px 12px;
    border-radius: 12px;
    color: white;
    text-decoration: none;
    font-size: 13px;
    transition: background 0.3s;
}

.chat-header .logout-btn:hover {
    background: #cc0000;
}

/* Chat container takes full available space */
#chat-box {
    flex: 1; /* expand to fill space */
    overflow-y: auto;
    padding: 15px;
    display: flex;
    flex-direction: column;

    /* ✅ WhatsApp-style wallpaper */
    background: url("https://preview.redd.it/qwd83nc4xxf41.jpg?width=640&crop=smart&auto=webp&s=e82767fdf47158e80604f407ce4938e44afc6c25");
    background-size: cover;
    background-repeat: repeat;
}

/* Message bubbles */
.mymsg, .othermsg {
    max-width: 70%;
    padding: 10px 15px;
    border-radius: 20px;
    margin: 5px;
    display: inline-block;
    position: relative;
    word-wrap: break-word;
    font-size: 14px;
}

/* My messages (right side, green bubble) */
.mymsg {
    background: #dcf8c6;
    align-self: flex-end;
    border-bottom-right-radius: 5px;
}

/* Other messages (left side, white bubble) */
.othermsg {
    background: #ffffff;
    align-self: flex-start;
    border-bottom-left-radius: 5px;
}

/* Username style */
.username {
    font-weight: bold;
    font-size: 12px;
    color: #555;
    margin-bottom: 3px;
    display: block;
}

/* Time style */
.time {
    font-size: 10px;
    color: gray;
    position: absolute;
    bottom: 2px;
    right: 8px;
}

/* Chat form pinned at bottom */
#chatForm {
    display: flex;
    justify-content: space-between;
    background: #f0f0f0;
    padding: 10px;
    border-top: 1px solid #ccc;
}

#message {
    flex: 1;
    padding: 10px;
    border-radius: 20px;
    border: 1px solid #ccc;
    outline: none;
    font-size: 14px;
}

#chatForm button {
    background: #25d366;
    border: none;
    color: white;
    padding: 10px 15px;
    margin-left: 10px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.3s;
}

#chatForm button:hover {
    background: #1ebe57;
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<!-- 🔹 New Fancy Header -->
<div class="chat-header">
  <div class="title">
    <span class="logo">💬</span> 
    <span>Chat box</span>
  </div>
  <div class="user-section">
    <span class="welcome">Hi, <?php echo $_SESSION['username']; ?> 👋</span>
    <a href="logout.php" class="logout-btn">logout</a>
  </div>
</div>

<div id="chat-box"></div>

<form id="chatForm">
  <input type="text" id="message" placeholder="Type a message..." required>
  <button type="submit">&#9658;</button>
</form>

<script>
function loadMessages(){
  $.get("fetch_messages.php", function(data){
    $("#chat-box").html(data);
    $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
  });
}
setInterval(loadMessages, 1500); 
loadMessages();

$("#chatForm").submit(function(e){
  e.preventDefault();
  var msg = $("#message").val();
  $.post("send_message.php", {message: msg}, function(){
      $("#message").val("");
      loadMessages();
  });
});
</script>
</body>
</html>
