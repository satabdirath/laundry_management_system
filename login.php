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
    button {
      background-color: purple;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      width: 100%;
    }
    button:hover {
      opacity: 0.8;
    }
    .registerbtn {
      width: auto;
      padding: 10px 18px;
      background-color: #f44336;
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
      .registerbtn {
        width: 100%;
      }
    }
  </style>
  </head>
  <body>
    <h2>Login</h2>
    <form class="" action="" method="post" autocomplete="off">
      <label for="usernameemail">Email : </label>
      <input type="text" name="usernameemail" id = "usernameemail" required value=""> <br>
      <label for="password">Password : </label>
      <input type="password" name="password" id = "password" required value=""> <br>
      <button type="submit" name="submit">Login</button>
      <br>


      <div style="display: flex; justify-content: space-between; align-items: center;">
  <button style="width: 100px; height: 30px; background-color: indigo; border: none;"><a href="registration.php" style="text-decoration: none; color: white;">Register</a></button>
  <a href="forgot_password.php" style="text-decoration: none; margin-right: 20px;">Forgot password?</a>
</div>


  </form>
  </body>
</html>

