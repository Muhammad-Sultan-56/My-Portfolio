<?php
require_once("./admin/config.php");

if (isset($_POST['send']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');

    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if the form data is valid
        if (!empty($name) && !empty($email) && !empty($message)) {

            // Prepare the SQL query
            $query = "INSERT INTO users_messages (name, email, message) VALUES (?, ?, ?)";
            $stmt = $con->prepare($query);
            $stmt->bind_param("sss", $name, $email, $message);

            // Execute the query
            if ($stmt->execute()) {
                $_SESSION['success'] = "Message sent successfully!";
            } else {
                $_SESSION['error'] = "Failed to send message. Please try again.";
            }
            $stmt->close();
        } else {
            $_SESSION['error'] = "All fields are required.";
        }
    } else {
        $_SESSION['error'] = "Invalid email address.";
    }
}
?>

<!-- contact section -->
<section class="contact-section mb-4" id="contact">
    <h2 class="text-center mb-4">
        Contact <span class="text-primary"> Me</span>
    </h2>

    <div class="container shadow p-3">

        <?php
        if (!empty($_SESSION['error'])) {
            $msg = $_SESSION['error'];
            echo "<div class='alert alert-danger alert-dismissible fade show' id='alert' role='alert'>
                        <strong>Warning!</strong> $msg
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
            unset($_SESSION['error']);
        }

        if (!empty($_SESSION['success'])) {
            $msg = $_SESSION['success'];
            echo "<div class='alert alert-success alert-dismissible fade show' id='alert' role='alert'>
                        <strong>Thanks for Contact!</strong> $msg
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
            unset($_SESSION['success']);
        }
        ?>

        <div class="row contact-container">
            <div class="col-md-6 contact-info">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="icon">
                        <i class="fas fa-map-marker-alt fs-3"></i>
                    </span>
                    <div>
                        <h5>Address</h5>
                        <p>Moza Rajapur, Tehsil & District Lodhran, Pakistan.</p>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="icon">
                        <i class="fas fa-phone fs-3"></i>
                    </span>
                    <div>
                        <h5>Mobile</h5>
                        <p>+92305-1608550</p>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="icon">
                        <i class="fas fa-envelope fs-3"></i>
                    </span>
                    <div>
                        <h5>Email</h5>
                        <p>sultankhiji56@gmail.com</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 message-form">
                <form action="" method="POST">
                    <input type="text" name="name" placeholder="Enter Name" required />
                    <input type="email" name="email" placeholder="Enter Email" required />
                    <textarea name="message" placeholder="Your Message" required></textarea>
                    <button class="btn-primary" type="submit" name="send">Send Now</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="bg-primary text-white text-center py-3">
        <p class="mb-0">&copy; 2024 @Muhammad Sultan. All rights reserved.</p>
    </div>
</footer>



<script>
    let alert = document.getElementById("alert");
    setTimeout(() => {
        alert.style.display = "none"
    }, 5000);
</script>