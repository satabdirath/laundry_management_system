<?php
require 'config.php';
if(!empty($_SESSION["id"])){
  header("Location: index.php");
}
if(isset($_POST["submit"])){
  $usernameemail = $_POST["usernameemail"];
  $password = $_POST["password"];
  $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$usernameemail'");
  $row = mysqli_fetch_assoc($result);
  if(mysqli_num_rows($result) > 0){
    if($password == $row['password']){
      $_SESSION["login"] = true;
      $_SESSION["id"] = $row["id"];
      header("Location: index.php");
    }
    else{
      echo
      "<script> alert('Wrong Password'); </script>";
    }
  }
  else{
    echo
    "<script> alert('User Not Registered'); </script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="css/auth.css" rel="stylesheet">
  </head>
  <body>
    <div class="login-container">
      <h2>Login</h2>
      <form action="" method="post" autocomplete="off">
        <label for="usernameemail">Email : </label>
        <input type="text" name="usernameemail" id="usernameemail" required value=""> <br>
        
        <label for="password">Password : </label>
        <input type="password" name="password" id="password" required value=""> <br>
        
        <button type="submit" name="submit">Login</button>
        
        <div class="form-links">
          <a href="registration.php">Register</a>
          <a href="forgot_password.php">Forgot password?</a>
        </div>
      </form>
    </div>
  </body>
</html>