<?php
require 'config.php';
if(empty($_SESSION["id"])){
  header("Location: login.php");
}
$user_id = $_SESSION["id"];
$query = "SELECT * FROM laundry_requests WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Requests</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>

      .content {
        margin-left: 250px;
        padding: 20px;
      }

      /* Sidebar collapse button for mobile */
    

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
    </div>

    <div class="content">
    
      <h2>Laundry Requests</h2>
      
      <?php if(mysqli_num_rows($result) > 0): ?>
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
              <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td><?php echo $row['pickup_date']; ?></td>
                  <td><?php echo $row['pickup_time']; ?></td>
                  <td><?php echo $row['delivery_date']; ?></td>
                  <td><?php echo $row['delivery_time']; ?></td>
                  <td><?php echo $row['wash_fold']; ?></td>
                  <td><?php echo $row['wash_iron']; ?></td>
                  <td><?php echo $row['dry_clean']; ?></td>
                  <td><?php echo $row['price']; ?></td>
                  <td><?php echo $row['status']; ?></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p>No laundry requests found. <a href="laundry_request.php">Book your request now!</a></p>
      <?php endif; ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script>
      // Toggle sidebar for mobile
      document.getElementById('sidebar-toggle').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('active');
      });
    </script>
  </body>
</html>

