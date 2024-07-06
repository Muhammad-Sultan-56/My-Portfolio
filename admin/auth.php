<?php

session_start();

require_once("config.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
} else {
    // SQL query to get user data
    $query = "SELECT * FROM admin WHERE id='$_SESSION[admin_id]'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    $_SESSION['admin_name'] = $row['name'];
}
