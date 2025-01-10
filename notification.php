<?php
require 'config.php';

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
}

// Check for laundry request confirmation for all users
$sql = "SELECT laundry_requests.id, 
               laundry_requests.status, 
               notifications.id AS notification_id, 
               users.name, 
               laundry_requests.user_id 
        FROM laundry_requests
        LEFT JOIN notifications 
        ON laundry_requests.id = notifications.request_id 
           AND laundry_requests.user_id = notifications.user_id
        INNER JOIN users 
        ON laundry_requests.user_id = users.id
        ORDER BY laundry_requests.created_at DESC";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $status = ucfirst($row['status']); // Capitalize the first letter of status
    $notification_msg = "Your laundry request with ID " . $row['id'] . " has been $status";
    $current_user_id = $row['user_id'];

    // Check if notification already exists
    $sql = "SELECT * FROM notifications WHERE user_id = $current_user_id AND message = '$notification_msg'";
    $check_result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($check_result) == 0) {
        $sql = "INSERT INTO notifications(user_id, message, read_status) VALUES ($current_user_id, '$notification_msg', 0)";
        mysqli_query($conn, $sql);
    }
}

// Fetch notifications for all users
$sql = "SELECT notifications.*, users.name 
        FROM notifications
        INNER JOIN users ON notifications.user_id = users.id
        ORDER BY notifications.created_at DESC";
$result = mysqli_query($conn, $sql);
$notifications = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>All Notifications</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/notification.css" rel="stylesheet">
  </head>
  <body>

    <?php include 'sidebar.php'; ?>
    
    <div class="notifications-container">
      <h2>All Notifications</h2>

      <?php if (empty($notifications)): ?>
        <p>No notifications available.</p>
      <?php else: ?>
        <ul class="list-unstyled">
          <?php foreach ($notifications as $notification): ?>
            <li class="notification-item">
              <strong><?php echo htmlspecialchars($notification["name"]); ?>:</strong>
              <span class="notification-message"><?php echo htmlspecialchars($notification["message"]); ?></span>
              <?php if (!$notification["read_status"]): ?>
                <a href="?mark_read=<?php echo $notification["id"]; ?>">Mark as read</a>
              <?php endif; ?>
              <br>
              <small><?php echo date("M d, Y h:i A", strtotime($notification["created_at"])); ?></small>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      
      <a href="index.php" class="btn btn-secondary ms-2">Go back</a>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
  document.addEventListener('DOMContentLoaded', function () {
    // Add click event listener to toggle read/unread
    document.querySelectorAll('.toggle-read-status').forEach(function (link) {
      link.addEventListener('click', function () {
        const notificationId = this.getAttribute('data-id');
        const notificationItem = document.getElementById(`notification-${notificationId}`);
        const messageSpan = notificationItem.querySelector('.notification-message');

        // Toggle the read status
        const isRead = notificationItem.classList.toggle('read');

        // Update the link text
        this.textContent = isRead ? 'Mark as unread' : 'Mark as read';

        // Send AJAX request to update the read status in the database
        fetch('update_notification_status.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ id: notificationId, read_status: isRead ? 1 : 0 }),
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              console.log('Notification status updated successfully.');
            } else {
              console.error('Failed to update notification status.');
            }
          })
          .catch(error => console.error('Error:', error));
      });
    });
  });
</script>

  </body>
</html>
