<?php
require 'config.php';

if(!isset($_SESSION["login"])){
  header("Location: login.php");
}

$user_id = $_SESSION["id"];

// Check for laundry request confirmation
$sql = "SELECT laundry_requests.id, laundry_requests.status, notifications.id AS notification_id 
        FROM laundry_requests
        LEFT JOIN notifications ON laundry_requests.id = notifications.request_id AND notifications.user_id = $user_id
        WHERE laundry_requests.user_id = $user_id
        ORDER BY laundry_requests.created_at DESC";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
  $status = ucfirst($row['status']); // capitalize first letter of status
  $notification_msg = "Your laundry request with ID " . $row['id'] . " has been $status";
  
  // Check if notification already exists
  $sql = "SELECT * FROM notifications WHERE user_id = $user_id AND message = '$notification_msg'";
  $check_result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($check_result) == 0) {
    $sql = "INSERT INTO notifications(user_id, message, read_status) VALUES ($user_id, '$notification_msg', 0)";
    mysqli_query($conn, $sql);
  }
}

// Fetch notifications
$sql = "SELECT * FROM notifications WHERE user_id = $user_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$notifications = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Sent Notifications</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        padding-top: 30px;
      }
      
      h2 {
        text-align: center;
        color: #007bff;
      }

      .notifications-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }

      .notification-item {
        padding: 15px;
        border-bottom: 1px solid #eee;
        margin-bottom: 10px;
      }

      .notification-item:last-child {
        border-bottom: none;
      }

      .notification-item strong {
        color: #dc3545;
      }

      .notification-item a {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
      }

      .notification-item a:hover {
        text-decoration: underline;
      }

      .notification-item small {
        color: #6c757d;
        font-size: 0.9rem;
      }

      .btn-back {
        display: block;
        width: 100%;
        text-align: center;
        margin-top: 20px;
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
      }

      .btn-back:hover {
        background-color: #0056b3;
        cursor: pointer;
      }

      @media (max-width: 768px) {
        .notifications-container {
          padding: 15px;
        }
      }

    </style>
  </head>
  <body>

    <?php include 'sidebar.php'; ?>
    
    <div class="notifications-container">
      <h2>Sent Notifications</h2>

      <?php if(empty($notifications)): ?>
        <p>No new notifications. Check back later.</p>
      <?php else: ?>
        <ul class="list-unstyled">
          <?php foreach($notifications as $notification): ?>
            <li class="notification-item">
              <?php if(!$notification["read_status"]): ?>
                <strong>
              <?php endif; ?>
              <?php echo $notification["message"]; ?>
              <?php if(!$notification["read_status"]): ?>
                </strong>
                <a href="?mark_read=<?php echo $notification["id"]; ?>">Mark as read</a>
              <?php endif; ?>
              <br>
              <small><?php echo date("M d, Y h:i A", strtotime($notification["created_at"])); ?></small>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      
      <button class="btn-back" onclick="window.location.href='dashboard.html'">Go back</button>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
  </body>
</html>
