<?php
require 'config.php';

if(isset($_POST["submit"])){
  $username = $_POST["username"];

  // check if username exists
  $result = mysqli_query($conn, "SELECT * FROM users WHERE name = '$username'");
  if(mysqli_num_rows($result) == 0){
    $message = "<span style='color:red'>Username not found.</span>";
  } else {
    // get the new password from user
    $new_password = $_POST["new_password"];

    // update user's password in database
    mysqli_query($conn, "UPDATE users SET password = '$new_password' WHERE name = '$username'");

    // show success message
    $message = "<span style='color:green'>Your password has been reset.</span>";
   
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Forgot Password</title>
    <style>
      body {
        background-image: url('https://static.vecteezy.com/system/resources/previews/001/984/880/original/abstract-colorful-geometric-overlapping-background-and-texture-free-vector.jpg');
        background-size: cover;
        font-family: Arial, sans-serif;
        background-color: #F9F9F9;
      }
   
      form {
        border: 3px solid #f1f1f1;
        background-color: #ffffff;
        max-width: 500px;
        margin: 0 auto;
        padding: 20px;
      }
   
      h2 {
        text-align: center;
        margin-top: 0;
      }
   
      input[type=text], input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
      }
   
      button[name=submit] {
        background-color: purple;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        float: left;
      }
   
      button[name=submit]:hover {
        opacity: 0.8;
      }
   
      a[href="login.php"] {
        float: right;
      }
   
      .container {
        padding: 16px;
      }
   
      span.psw {
        float: right;
        padding-top: 16px;
      }
   
      .clearfix::after {
        content: "";
        clear: both;
        display: table;
      }
   
      @media screen and (max-width: 300px) {
        span.psw {
          display: block;
          float: none;
        }
   
        button[name=submit] {
          width: 100%;
        }
      }
    </style>
  </head>
  <body>
  <form method="post">
    <h1>Forgot Password</h1>
    <?php if(isset($message)) echo "<p>$message</p>"; ?>
   
      <label for="username">Username:</label>
      <input type="text" name="username" required>
      <br>
      <label for="new_password">New Password:</label>
      <input type="password" name="new_password" required>
      <br>
      <button type="submit" name="submit">Reset Password</button>
      <a href="login.php">Back to Login</a>
    </form>
  </body>
</html>
