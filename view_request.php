<?php
require 'config.php';

// Fetch data directly
$query = "SELECT * FROM laundry_requests"; 
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
      .content {
        margin-left: 250px;
        padding: 20px;
      }
      @media (max-width: 768px) {
        .sidebar {
          width: 0;
          position: absolute;
        }
        .content {
          margin-left: 0;
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

    <div class="content">
      <h2>Laundry Requests</h2>
      
      <?php if (!empty($laundry_requests)): ?>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Pickup Date</th>
                <th>Pickup Time</th>
                <th>Delivery Date</th>
                <th>Delivery Time</th>
                <th>Wash and Fold</th>
                <th>Wash and Iron</th>
                <th>Dry Clean</th>
                <th>Price</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($laundry_requests as $row): ?>
                <tr>
                  <td><?= htmlspecialchars($row['pickup_date']); ?></td>
                  <td><?= htmlspecialchars($row['pickup_time']); ?></td>
                  <td><?= htmlspecialchars($row['delivery_date']); ?></td>
                  <td><?= htmlspecialchars($row['delivery_time']); ?></td>
                  <td><?= htmlspecialchars($row['wash_fold']); ?></td>
                  <td><?= htmlspecialchars($row['wash_iron']); ?></td>
                  <td><?= htmlspecialchars($row['dry_clean']); ?></td>
                  <td><?= htmlspecialchars(number_format($row['price'], 2)); ?></td>
                  <td><?= htmlspecialchars($row['status']); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <a href="index.php" class="btn btn-secondary ms-2">Go back</a>
        </div>
      <?php else: ?>
        <p>No laundry requests found. <a href="laundry_request.php">Book your request now!</a></p>
      <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
  </body>
</html>
