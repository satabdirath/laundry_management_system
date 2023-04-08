<?php
require 'config.php';
if(!empty($_SESSION["id"])){
  $id = $_SESSION["id"];
  $result = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
  $row = mysqli_fetch_assoc($result);
}
else{
  header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Index</title>
    <style>
      body {
        background-image: url('https://static.vecteezy.com/system/resources/previews/001/984/880/original/abstract-colorful-geometric-overlapping-background-and-texture-free-vector.jpg');
        background-size: cover;
        text-align: center;
        color: black;
      }
      h1 {
        margin-top: 100px;
        font-size: 50px;
      }
      p {
        font-size: 24px;
      }
      .button {
        display: inline-block;
        padding: 12px 24px;
        background-color: purple;
        color: white;
        text-align: center;
        font-size: 18px;
        border-radius: 8px;
        margin-top: 50px;
        text-decoration: none;
      }
      .button:hover {
        background-color: indigo;
      }
    </style>
  </head>
  <body>
    <h1>Welcome <?php echo $row["name"]; ?> to our website !! </h1>
    <p>  Our system is designed to make your laundry management easier and more efficient. With our user-friendly interface, you can easily manage all your laundry requests, view notifications, and update your account information.

We understand that laundry day can be a hassle, but our system is here to help you streamline the process and make it a breeze. Whether you need a quick wash and fold, or a more extensive dry cleaning service, we've got you covered.

Thank you for choosing our Laundry Management System. We're excited to make your laundry experience as stress-free as possible!</p>
    <a href="dashboard.html" class="button">Dashboard</a>
    <a href="logout.php" class="button">Logout</a>
  </body>
</html>
