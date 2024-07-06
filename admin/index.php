<?php
include("auth.php");
require_once("config.php");

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['mark_read_id'])) {
    $id = intval($_POST['mark_read_id']);
    $query = "UPDATE users_messages SET status='read' WHERE id=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
  }

  if (isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $query = "DELETE FROM users_messages WHERE id=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
  }

  if (isset($_POST['mark_all_read'])) {
    $query = "UPDATE users_messages SET status='read' WHERE status='unread'";
    mysqli_query($con, $query);
  }
}

// Fetch messages from the database
$query = "SELECT * FROM users_messages";
$result = mysqli_query($con, $query);
$messages = [];
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Messages</title>
  <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
  <!-- Your other CSS links -->
  <?php include("./includes/css-links.php") ?>
</head>

<body>
  <div class="sidebar bg-primary">
    <h4 class="text-center text-white"><i class="fa-solid fa-square-poll-horizontal"></i> Dashboard</h4>
    <hr>
    <a href="index.php"><i class="fa-solid fa-comments"></i> User Messages</a>
    <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
  </div>

  <nav class="navbar navbar-light">
    <div class="container-fluid end">
      <p class="ms-auto m-2"><b class="text-primary">Welcome!</b> <?= $_SESSION['admin_name'] ?></p>
    </div>
  </nav>

  <div class="content">
    <h3>Users Messages</h3>
    <div class="card">
      <div class="card-body">
        <form method="post">
          <button name="mark_all_read" class="btn btn-primary mb-3">Mark All as Read</button>
        </form>
        <table id="messagesTable" class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Message</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($messages as $message) : ?>
              <tr>
                <td><?= $message['id'] ?></td>
                <td><?= $message['name'] ?></td>
                <td><?= $message['email'] ?></td>
                <td> <span class="badge bg-light text-dark" type="button" data-bs-toggle="modal" data-bs-target="#message">View Message</span> </td>
                <td>
                  <?= $message['status'] === 'unread' ? '<span class="badge bg-success">Unread</span>' : '<span class="badge bg-primary">Read</span>' ?>
                </td>
                <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                      Actions
                    </button>
                    <ul class="dropdown-menu">
                      <li>
                        <a class="dropdown-item" href="mark_read.php?id=<?= $message['id'] ?>"><i class="fa-solid fa-check-double"></i> Mark Read</a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="delete_message.php?id=<?= $message['id'] ?>"><i class="fa-solid fa-trash"></i> Delete</a>
                      </li>
                    </ul>
                  </div>
                </td>
              </tr>


              <!-- Modal -->
              <div class="modal fade" id="message" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">User Message</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <?= $message['message'] ?>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>

            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
  <?php include("./includes/js-links.php") ?>

  <script>
    $(document).ready(function() {
      $('#messagesTable').DataTable();
    });
  </script>
</body>

</html>