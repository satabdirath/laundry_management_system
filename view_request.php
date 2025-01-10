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

      /* Table Styles */
      table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
      }

      th, td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
      }

      th {
        background-color: #f2f2f2;
        color: #333;
      }

      tr:nth-child(even) {
        background-color: #f9f9f9;
      }

      tr:hover {
        background-color: #f1f1f1;
      }

      td {
        word-wrap: break-word;
        max-width: 200px; /* Prevent long text overflow */
      }

      /* Add a little shadow and round the corners of the table */
      table {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
      }

      /* Table Header */
      th {
        font-size: 16px;
        font-weight: 600;
        padding: 15px;
      }

      /* Styling the Go Back Button */
      .btn-secondary {
        background-color: #6c757d;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 20px;
        display: inline-block;
      }

      .btn-secondary:hover {
        background-color: #5a6268;
      }

      /* Mobile Responsive Adjustments */
      @media (max-width: 768px) {
        table {
          width: 100%;
        }

        td, th {
          padding: 8px;
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
                <?= htmlspecialchars($row['name']); ?><br>
                <?= htmlspecialchars($row['address']); ?>
              </td>

              <!-- Combine Wash & Fold, Wash & Iron, and Dry Clean -->
              <td>
                <?php if (!empty($row['wash_fold'])): ?>
                  <div>Wash & Fold: <?= htmlspecialchars($row['wash_fold']); ?></div>
                <?php endif; ?>
                <?php if (!empty($row['wash_iron'])): ?>
                  <div>Wash & Iron: <?= htmlspecialchars($row['wash_iron']); ?></div>
                <?php endif; ?>
                <?php if (!empty($row['dry_clean'])): ?>
                  <div>Dry Clean: <?= htmlspecialchars($row['dry_clean']); ?></div>
                <?php endif; ?>
              </td>

              <!-- Combine Pickup Date and Time -->
              <td>
  <?php 
  $pickup_datetime = new DateTime($row['pickup_date'] . ' ' . $row['pickup_time']);
  echo $pickup_datetime->format('jS M Y g:i A');
  ?>
</td>

<!-- Combine Delivery Date and Time -->
<td>
  <?php 
  $delivery_datetime = new DateTime($row['delivery_date'] . ' ' . $row['delivery_time']);
  echo $delivery_datetime->format('jS M Y g:i A');
  ?>
</td>


              <!-- Price -->
              <td><?= htmlspecialchars(number_format($row['price'], 2)); ?></td>

              <!-- Status -->
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
