<?php
session_start();

include_once "config.php";

if (isset($_POST['login']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and filter form data
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Prepare SQL query to check user credentials
    $query = "SELECT * FROM `admin` WHERE email=? AND `password`=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($result->num_rows == 1) {
        $_SESSION['admin_id'] = $row['id'];
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid email or password!";
        header("Location: login.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Bootstrap CSS -->
    <?php include("./includes/css-links.php") ?>
</head>

<body>
    <div class="container">
        <div class="login-container">
            <?php
            if (!empty($_SESSION['error'])) {
                $msg = $_SESSION['error'];
                echo "<div class='alert alert-danger alert-dismissible fade show' id='alert' role='alert'>
                        <strong>Warning!</strong> $msg
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
                unset($_SESSION['error']);
            }
            ?>
            <h4 class="text-center">Admin <span class="text-primary">Login</span></h4>
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Email</label>
                    <input type="email" class="form-control shadow-none" id="username" name="email" placeholder="Enter here..." required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control shadow-none" id="password" name="password" placeholder="Enter here..." required>
                </div>
                <div class="d-grid">
                    <button type="submit" name="login" class="btn btn-primary">Login <i class="fa-solid fa-right-to-bracket"></i></button>
                </div>
            </form>
        </div>
    </div>

    <!--  JS -->
    <?php include("./includes/js-links.php") ?>

</body>

</html>

<script>
    let alert = document.getElementById("alert");
    setTimeout(() => {
        alert.style.display = "none"
    }, 4000);
</script>