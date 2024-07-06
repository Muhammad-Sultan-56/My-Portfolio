<?php
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = "UPDATE users_messages SET status='read' WHERE status='unread'";
    mysqli_query($con, $query);
    echo json_encode(['success' => true]);
}
