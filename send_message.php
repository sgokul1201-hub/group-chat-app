<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) exit;

$message = trim($_POST['message']);
if ($message != "") {
    $stmt = $conn->prepare("INSERT INTO messages (user_id, message) VALUES (?,?)");
    $stmt->bind_param("is", $_SESSION['user_id'], $message);
    $stmt->execute();
}
?>
