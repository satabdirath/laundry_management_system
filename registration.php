<?php
require 'config.php';
if(!empty($_SESSION["id"])){
  header("Location: index.php");
}
if(isset($_POST["login"])){
  $email = $_POST["email"];
  $password = $_POST["password"];
  $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result) == 1){
    $row = mysqli_fetch_assoc($result);
    $_SESSION["id"] = $row["id"];
    $_SESSION["name"] = $row["name"];
    header("Location: index.php");
  }
  else{
    echo
    "<script> alert('Invalid Email or Password'); </script>";
  }
}
if(isset($_POST["register"])){
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $confirmpassword = $_POST["confirmpassword"];
  $duplicate = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
  if(mysqli_num_rows($duplicate) > 0){
    echo
    "<script> alert('Email Has Already Been Used'); </script>";
  }
  else{
    if($password == $confirmpassword){
      $query = "INSERT INTO users (name, email, password) VALUES('$name','$email','$password')";
      mysqli_query($conn, $query);
      echo
      "<script> alert('Registration Successful'); </script>";
    }
    else{
      echo
      "<script> alert('Password Does Not Match'); </script>";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Registration</title>
    <link href="css/auth.css" rel="stylesheet">
  </head>
  <body>
  

    <div class="login-container">
      <h2>Registration</h2>
      <form method="post" autocomplete="off">
        <label for="name"><b>Name:</b></label>
        <input type="text" placeholder="Enter Name" name="name" required>

        <label for="email"><b>Email:</b></label>
        <input type="email" placeholder="Enter Email" name="email" required>

        <label for="password"><b>Password:</b></label>
        <input type="password" placeholder="Enter Password" name="password" required>

        <label for="confirmpassword"><b>Confirm Password:</b></label>
        <input type="password" placeholder="Confirm Password" name="confirmpassword" required>

        <button type="submit" name="register">Register</button>
        <div class="form-links">
        <a href="login.php"></a>
          <a href="login.php">Already Registered?</a>
        </div>
    </form>
    </div>
  </body>
</html>
