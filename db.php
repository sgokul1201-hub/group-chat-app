<?php
$host = "localhost";
$user = "root";   // your MySQL username
$pass = "";       // your MySQL password
$db   = "chatapp";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>

