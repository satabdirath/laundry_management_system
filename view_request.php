<?php
require 'config.php';


if(!isset($_SESSION["login"])){
  header("Location: login.php");
}

$user_id = $_SESSION["id"];

// Fetch data from both laundry_requests and users tables
$query = "SELECT laundry_requests.*, users.name, users.address 
          FROM laundry_requests 
          JOIN users ON laundry_requests.user_id = users.id"; // Assuming user_id is the common field

$result = mysqli_query($conn, $query);

if (!$result) {
    // Handle query errors
    die("Query failed: " . mysqli_error($conn));
}

// Fetch all rows into an array
$laundry_requests = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Free the result set
mysqli_free_result($result);

// Close the connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Requests</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
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
  <div class="sidebar" id="sidebar">
    <?php include 'sidebar.php'; ?>
    <div class="mobile-menu">
      <a href="logout.php">Logout</a> |
      <a href="laundry_request.php">Add Request</a> |
      <a href="view_request.php">View Requests</a>
    </div>
  </div>

  <!-- Content -->
  <div class="content">
    <h2 class="text-center mb-4">Laundry Requests</h2>
    
    <?php if (!empty($laundry_requests)): ?>
      <div class="table-responsive" style="margin-left: 150px;">
        <table class="table table-hover table-bordered text-center align-middle">
          <thead>
            <tr>
              <th>Name & Address</th>
              <th>Order</th>
              <th>Pickup</th>
              <th>Delivery</th>
              <th>Price</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($laundry_requests as $row): ?>
              <tr>
                <!-- Combine Name and Address -->
                <td>
                  <strong><?= htmlspecialchars($row['name']); ?></strong><br>
                  <small><?= htmlspecialchars($row['address']); ?></small>
                </td>

                <!-- Combine Wash & Fold, Wash & Iron, and Dry Clean -->
                <td>
                  <?php if (!empty($row['wash_fold'])): ?>
                    <div><strong>Wash & Fold:</strong> <?= htmlspecialchars($row['wash_fold']); ?></div>
                  <?php endif; ?>
                  <?php if (!empty($row['wash_iron'])): ?>
                    <div><strong>Wash & Iron:</strong> <?= htmlspecialchars($row['wash_iron']); ?></div>
                  <?php endif; ?>
                  <?php if (!empty($row['dry_clean'])): ?>
                    <div><strong>Dry Clean:</strong> <?= htmlspecialchars($row['dry_clean']); ?></div>
                  <?php endif; ?>
                </td>

                <!-- Pickup Date and Time -->
                <td>
                  <?php 
                  $pickup_datetime = new DateTime($row['pickup_date'] . ' ' . $row['pickup_time']);
                  echo $pickup_datetime->format('jS M Y g:i A');
                  ?>
                </td>

                <!-- Delivery Date and Time -->
                <td>
                  <?php 
                  $delivery_datetime = new DateTime($row['delivery_date'] . ' ' . $row['delivery_time']);
                  echo $delivery_datetime->format('jS M Y g:i A');
                  ?>
                </td>

                <!-- Price -->
                <td>&#36;<?= htmlspecialchars(number_format($row['price'], 2)); ?></td>

                <!-- Status -->
                <td>
                  <span class="badge bg-<?php echo ($row['status'] === 'completed') ? 'success' : 'warning'; ?>">
                    <?= htmlspecialchars(ucfirst($row['status'])); ?>
                  </span>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <a href="index.php" class="btn btn-secondary ms-2">Go back</a>
      </div>
    <?php else: ?>
      <p class="text-center">No laundry requests found. <a href="laundry_request.php">Book your request now!</a></p>
    <?php endif; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
