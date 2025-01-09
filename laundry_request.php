<?php
require 'config.php';

if(!isset($_SESSION["login"])){
  header("Location: login.php");
}

if(isset($_POST["submit"])){
  $user_id = $_SESSION["id"];
  $user_id = $_POST["selected_user"]; // Get the selected user id from dropdown
  $pickup_date = $_POST["pickup_date"];
  $pickup_time = $_POST["pickup_time"];
  $delivery_date = $_POST["delivery_date"];
  $delivery_time = $_POST["delivery_time"];
  $wash_fold = $_POST["wash_fold"];
  $wash_iron = $_POST["wash_iron"];
  $dry_clean = $_POST["dry_clean"];
  $price = calculate_price($wash_fold, $wash_iron, $dry_clean);
  $status = "Pending";
  
  // Insert the data along with the selected user id
  $sql = "INSERT INTO laundry_requests ( user_id, pickup_date, pickup_time, delivery_date, delivery_time, wash_fold, wash_iron, dry_clean, price, status) 
          VALUES ( '$user_id', '$pickup_date', '$pickup_time', '$delivery_date', '$delivery_time', '$wash_fold', '$wash_iron', '$dry_clean', '$price', '$status')";

  if(mysqli_query($conn, $sql)){
    echo "<script> alert('Laundry request submitted successfully.'); </script>";
  }
  else{
    echo "<script> alert('Error: Unable to submit laundry request.'); </script>";
  }
}

function calculate_price($wash_fold, $wash_iron, $dry_clean){
  $wash_fold_price = 10.5; // $10.5 per pound
  $wash_iron_price = 20.0; // $20.0 per pound
  $dry_clean_price = 30.5; // $30.5 per item
  
  $total_price = $wash_fold * $wash_fold_price + $wash_iron * $wash_iron_price + $dry_clean * $dry_clean_price;
  return round($total_price, 2);
}

// Fetch users from the database
$user_query = "SELECT id, name FROM users";
$user_result = mysqli_query($conn, $user_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Request</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Custom Styles -->
  <style>
    .content {
      margin-left: 250px;
      padding: 20px;
    }

    @media (max-width: 767px) {
      .content {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>

  <!-- Include Sidebar -->
  <?php include 'sidebar.php'; ?>
    <!-- Mobile Menu -->
    <div class="mobile-menu">
    <a href="logout.php">Logout</a> |
    <a href="laundry_request.php">Add Request</a> |
    <a href="view_request.php">View Requests</a>
  </div>

  <!-- Content Section -->
  <div class="content">
    <h2 class="mb-4">Laundry Request Form</h2>
    <form class="needs-validation" action="" method="post" novalidate>
      <div class="row">
        <div class="col-md-6">
        <div class="mb-3">
        <label for="selected_user" class="form-label">Select User:</label>
        <select name="selected_user" id="selected_user" class="form-control" required>
          <option value="" disabled selected>Select a user</option>
          <?php while($user = mysqli_fetch_assoc($user_result)): ?>
            <option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>

          <div class="mb-3">
            <label for="pickup_date" class="form-label">Pickup Date:</label>
            <input type="date" name="pickup_date" id="pickup_date" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="pickup_time" class="form-label">Pickup Time:</label>
            <input type="time" name="pickup_time" id="pickup_time" class="form-control" required>
          </div>
        </div>

        <div class="col-md-6">
          <div class="mb-3">
            <label for="delivery_date" class="form-label">Delivery Date:</label>
            <input type="date" name="delivery_date" id="delivery_date" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="delivery_time" class="form-label">Delivery Time:</label>
            <input type="time" name="delivery_time" id="delivery_time" class="form-control" required>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="mb-3">
            <label for="wash_fold" class="form-label">Wash &amp; Fold (number of clothes):</label>
            <input type="number" name="wash_fold" id="wash_fold" class="form-control" min="0" value="0">
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label for="wash_iron" class="form-label">Wash &amp; Iron (number of clothes):</label>
            <input type="number" name="wash_iron" id="wash_iron" class="form-control" min="0" value="0">
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label for="dry_clean" class="form-label">Dry Clean (number of clothes):</label>
            <input type="number" name="dry_clean" id="dry_clean" class="form-control" min="0" value="0">
          </div>
        </div>
      </div>

    
      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
      <a href="index.php" class="btn btn-secondary ms-2">Go back</a>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>



