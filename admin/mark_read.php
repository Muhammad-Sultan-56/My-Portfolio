<?php
require_once("auth.php");
// Handle delete request
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "UPDATE users_messages SET status='read' WHERE id= '$id'";
    $result = mysqli_query($con, $query);
    header("Location: index.php");
    exit();
}
