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
    body {
      background-color: #f8f9fa;
      font-family: 'Arial', sans-serif;
    }

    .content {
      margin: 20px auto;
      max-width: 90%;
      padding: 20px;
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table thead th {
      background: linear-gradient(45deg, #007bff, #0056b3);
      color: white;
      border: none;
      text-transform: uppercase;
    }

    .table-hover tbody tr:hover {
      background-color: #f1f5ff;
    }

    .btn-secondary {
      background-color: #6c757d;
      border: none;
      font-size: 14px;
      font-weight: 500;
    }

    .btn-secondary:hover {
      background-color: #5a6268;
    }

    .table th, .table td {
      vertical-align: middle;
    }

    @media (max-width: 768px) {
      .content {
        margin: 10px;
        padding: 10px;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <?php include 'sidebar.php'; ?>

  <!-- Container -->
  <div class="container content">
    <h2 class="text-center mb-4">Customer Table</h2>

    <?php if(mysqli_num_rows($result) > 0): ?>
      <div class="table-responsive" style="margin-left: 150px;">
        <table class="table table-hover table-bordered text-center align-middle">
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
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['address']); ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <a href="index.php" class="btn btn-secondary mt-3">Go back</a>
      </div>
    <?php else: ?>
      <p class="text-center">No customers found.</p>
    <?php endif; ?>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
