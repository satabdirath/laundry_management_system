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
    <title>requests</title>
    <style>
       body {
    background-image: url("https://static.vecteezy.com/system/resources/previews/001/984/880/original/abstract-colorful-geometric-overlapping-background-and-texture-free-vector.jpg");
    background-repeat: no-repeat;
    background-size: cover;
  }
  </style>
  </head>
  <body>
    
    <h2>current requests<h2>
    <?php if(mysqli_num_rows($result) > 0): ?>
      <table>
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
        <?php while($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?php echo $row['pickup_date']; ?></td><br>
            <td><?php echo $row['pickup_time']; ?></td><br>
            <td><?php echo $row['delivery_date']; ?></td>
            <td><?php echo $row['delivery_time']; ?></td>
            <td><?php echo $row['wash_fold']; ?></td>
            <td><?php echo $row['wash_iron']; ?></td>
            <td><?php echo $row['dry_clean']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['status']; ?></td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p>No laundry requests found,book your request below</p>
     
    <?php endif; ?>
    <br><br><a href="laundry_request.php">Book now</a>
    <br>
  </body>
</html>