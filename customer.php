<?php
require 'config.php';

if(!isset($_SESSION["login"])){
  header("Location: login.php");
}

$user_id = $_SESSION["id"];
// Fetch customer data from the users table
$query = "SELECT id, name, email, phone, address FROM users WHERE user_type = 0";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Table</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .content {
      padding: 20px;
    }
  </style>
</head>
<body>
  <!-- Container -->
  <?php include 'sidebar.php'; ?>
  <div class="container content">
    <h2>Customer Table</h2>

    <?php if(mysqli_num_rows($result) > 0): ?>
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th>Customer ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Address</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['address']; ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
          
        </table>
        <a href="index.php" class="btn btn-secondary ms-2">Go back</a>
      </div>
    <?php else: ?>
      <p>No customers found.</p>
    <?php endif; ?>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
