<?php
session_start();
include "db.php";

$result = $conn->query("SELECT m.*, u.username FROM messages m JOIN users u ON m.user_id=u.id ORDER BY m.id ASC");

while ($row = $result->fetch_assoc()) {
    if ($row['user_id'] == $_SESSION['user_id']) {
        echo "<div class='mymsg'><b>You:</b> ".htmlspecialchars($row['message'])."</div>";
    } else {
        echo "<div class='othermsg'><b>".$row['username'].":</b> ".htmlspecialchars($row['message'])."</div>";
    }
}
?>
