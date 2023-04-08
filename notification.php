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
    <title>Notifications</title>
    <style>
       body {
    background-image: url("https://static.vecteezy.com/system/resources/previews/001/984/880/original/abstract-colorful-geometric-overlapping-background-and-texture-free-vector.jpg");
    background-repeat: no-repeat;
    background-size: cover;
  }
  </style>
  </head>
  <body>
    <h2>Notifications</h2>
    <?php if(empty($notifications)): ?>
      <p>No new notifications. check back later</p>
    <?php else: ?>
      <ul>
        <?php foreach($notifications as $notification): ?>
          <li>
            <?php if(!$notification["read_status"]): ?>
              <strong>
            <?php endif; ?>
            <?php echo $notification["message"]; ?>
            <?php if(!$notification["read_status"]): ?>
              </strong>
              <a href="?mark_read=<?php echo $notification["id"]; ?>">Mark as read</a>
            <?php endif; ?>
            <br>
            <?php if(isset($notification["status"])): ?>
              <small>Status: <?php echo ucfirst($notification["status"]); ?></small>
              <?php if(isset($notification["notification_id"])): ?>
                <br>
                <small>Notification ID: <?php echo $notification["notification_id"]; ?></small>
              <?php endif; ?>
            <?php endif; ?>
            <br>
            <small><?php echo date("M d, Y h:i A", strtotime($notification["created_at"])); ?></small>
          </li>
        <?php endforeach; ?>
      </ul>

    <?php endif; ?>
    <br>
    <button onclick="window.location.href='dashboard.html'">Go back</button>
   
  </body>
</html>
