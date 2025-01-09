<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/sidebar.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
  <?php
  // Get the current page name
  $current_page = basename($_SERVER['PHP_SELF']);
  ?>

  <div class="sidebar">
    <h3>Menu</h3>
    <a href="index.php" class="<?= $current_page == 'index.php' ? 'active' : ''; ?>">Dashboard</a>
    <a href="laundry_request.php" class="<?= $current_page == 'laundry_request.php' ? 'active' : ''; ?>">Add Request</a>
    <a href="view_request.php" class="<?= $current_page == 'view_request.php' ? 'active' : ''; ?>">View Requests</a>
    <a href="customer.php" class="<?= $current_page == 'customer.php' ? 'active' : ''; ?>">Customers</a>
    <a href="notification.php" class="<?= $current_page == 'notification.php' ? 'active' : ''; ?>">Notifications</a>
    <!--<a href="forgot_password.php">Change Password</a>-->
    <a href="logout.php" class="<?= $current_page == 'logout.php' ? 'active' : ''; ?>">Logout</a>
  </div>

  <!-- Mobile Menu -->
  <div class="mobile-menu">
    <a href="logout.php" class="<?= $current_page == 'logout.php' ? 'active' : ''; ?>">Logout</a> |
    <a href="laundry_request.php" class="<?= $current_page == 'laundry_request.php' ? 'active' : ''; ?>">Add Request</a> |
    <a href="view_request.php" class="<?= $current_page == 'view_request.php' ? 'active' : ''; ?>">View Requests</a>
  </div>

</body>
</html>

