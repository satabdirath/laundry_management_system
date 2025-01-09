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
    <link href="css/auth.css" rel="stylesheet">
  </head>
  <body>
  <div class="login-container">
      <h2>Forgot Password</h2>
      <form method="post">
    <?php if(isset($message)) echo "<p>$message</p>"; ?>
   
      <label for="username">Username:</label>
      <input type="text" name="username" required>
      <br>
      <label for="new_password">New Password:</label>
      <input type="password" name="new_password" required>
      <br>
      <button type="submit" name="submit">Reset Password</button>
      <div class="form-links">
          <a href="registration.php"></a>
          <a href="login.php">Back to Login</a>
        </div>
      
    </form>
  </body>
</html>
