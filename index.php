<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laundry";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total orders
$total_orders_query = "SELECT COUNT(*) as total_orders FROM laundry_requests";
$total_orders_result = $conn->query($total_orders_query);
$total_orders = $total_orders_result->fetch_assoc()['total_orders'];

// Fetch total customers (unique user_id)
$total_customers_query = "SELECT COUNT(DISTINCT user_id) as total_customers FROM laundry_requests";
$total_customers_result = $conn->query($total_customers_query);
$total_customers = $total_customers_result->fetch_assoc()['total_customers'];

// Fetch total revenue (sum of prices)
$total_revenue_query = "SELECT SUM(price) as total_revenue FROM laundry_requests";
$total_revenue_result = $conn->query($total_revenue_query);
$total_revenue = $total_revenue_result->fetch_assoc()['total_revenue'];

// Convert revenue from USD to INR (1 USD = 80 INR)
$total_revenue_in_inr = $total_revenue * 80;

// Fetch pending orders
$pending_orders_query = "SELECT COUNT(*) as pending_orders FROM laundry_requests WHERE status != 'completed'";
$pending_orders_result = $conn->query($pending_orders_query);
$pending_orders = $pending_orders_result->fetch_assoc()['pending_orders'];

// Fetch data for wash_fold, wash_iron, and dry_clean from your database
$wash_fold_query = "SELECT SUM(wash_fold) AS wash_fold_count FROM laundry_requests";
$wash_iron_query = "SELECT SUM(wash_iron) AS wash_iron_count FROM laundry_requests";
$dry_clean_query = "SELECT SUM(dry_clean) AS dry_clean_count FROM laundry_requests";

// Execute queries
$wash_fold_result = $conn->query($wash_fold_query);
$wash_iron_result = $conn->query($wash_iron_query);
$dry_clean_result = $conn->query($dry_clean_query);

// Get the count from the results
$wash_fold_count = $wash_fold_result->fetch_assoc()['wash_fold_count'];
$wash_iron_count = $wash_iron_result->fetch_assoc()['wash_iron_count'];
$dry_clean_count = $dry_clean_result->fetch_assoc()['dry_clean_count'];

// Fetch Monthly Income (Current Month vs Previous Month)
$monthly_income_query = "
    SELECT 
        MONTH(pickup_date) AS month,
        SUM(wash_fold * 10) AS wash_fold_income,  -- Price for Wash & Fold = 10
        SUM(wash_iron * 20) AS wash_iron_income,  -- Price for Wash & Iron = 20
        SUM(dry_clean * 30) AS dry_clean_income   -- Price for Dry Clean = 30
    FROM laundry_requests
    WHERE YEAR(pickup_date) = YEAR(CURRENT_DATE)  -- Get current year's data
    GROUP BY MONTH(pickup_date)
";

$monthly_income_result = $conn->query($monthly_income_query);
$monthly_income = [];
while ($row = $monthly_income_result->fetch_assoc()) {
    $monthly_income[$row['month']] = [
        'wash_fold_income' => $row['wash_fold_income'],
        'wash_iron_income' => $row['wash_iron_income'],
        'dry_clean_income' => $row['dry_clean_income'],
    ];
}

// Fetch Yearly Income (Current Year vs Previous Year)
$yearly_income_query = "
    SELECT 
        YEAR(pickup_date) AS year,
        SUM(wash_fold * 10) AS wash_fold_income,  -- Price for Wash & Fold = 10
        SUM(wash_iron * 20) AS wash_iron_income,  -- Price for Wash & Iron = 20
        SUM(dry_clean * 30) AS dry_clean_income   -- Price for Dry Clean = 30
    FROM laundry_requests
    GROUP BY YEAR(pickup_date)
";

$yearly_income_result = $conn->query($yearly_income_query);
$yearly_income = [];
while ($row = $yearly_income_result->fetch_assoc()) {
    $yearly_income[$row['year']] = [
        'wash_fold_income' => $row['wash_fold_income'],
        'wash_iron_income' => $row['wash_iron_income'],
        'dry_clean_income' => $row['dry_clean_income'],
    ];
}

// Get Current Month and Previous Month Income
$current_month = date('n'); // Current month (1-12)
$previous_month = $current_month - 1 > 0 ? $current_month - 1 : 12; // Previous month

$monthlyIncomeValues = json_encode([
    $monthly_income[$current_month]['wash_fold_income'] ?? 0, 
    $monthly_income[$current_month]['wash_iron_income'] ?? 0, 
    $monthly_income[$current_month]['dry_clean_income'] ?? 0
]);

$previousMonthlyIncomeValues = json_encode([
    $monthly_income[$previous_month]['wash_fold_income'] ?? 0, 
    $monthly_income[$previous_month]['wash_iron_income'] ?? 0, 
    $monthly_income[$previous_month]['dry_clean_income'] ?? 0
]);

// Get Current Year and Previous Year Income
$current_year = date('Y'); // Current year
$previous_year = $current_year - 1; // Previous year

$yearlyIncomeValues = json_encode([
    $yearly_income[$current_year]['wash_fold_income'] ?? 0, 
    $yearly_income[$current_year]['wash_iron_income'] ?? 0, 
    $yearly_income[$current_year]['dry_clean_income'] ?? 0
]);

$previousYearlyIncomeValues = json_encode([
    $yearly_income[$previous_year]['wash_fold_income'] ?? 0, 
    $yearly_income[$previous_year]['wash_iron_income'] ?? 0, 
    $yearly_income[$previous_year]['dry_clean_income'] ?? 0
]);

// Pass values to frontend
echo "<script>
    const serviceTypes = ['Wash & Fold', 'Wash & Iron', 'Dry Clean'];
    const monthlyIncomeValues = $monthlyIncomeValues;
    const previousMonthlyIncomeValues = $previousMonthlyIncomeValues;
    const yearlyIncomeValues = $yearlyIncomeValues;
    const previousYearlyIncomeValues = $previousYearlyIncomeValues;
</script>";


// Close the connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome CDN -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="css/index.css" rel="stylesheet">
</head>
<body>
  <!-- Sidebar -->
  <?php include 'sidebar.php'; ?>



  <!-- Content -->
  <div class="content">
    <h2 id="dashboard">Dashboard</h2>

    <!-- Dashboard Cards -->
    <div class="row">
      <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
          <div class="card-body">
            <h5 class="card-title">
              <i class="fas fa-box"></i> Total Orders
            </h5>
            <p class="card-text"><?php echo number_format($total_orders); ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
          <div class="card-body">
            <h5 class="card-title">
              <i class="fas fa-users"></i> Total Customers
            </h5>
            <p class="card-text"><?php echo number_format($total_customers); ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
          <div class="card-body">
            <h5 class="card-title">
              <i class="fas fa-dollar-sign"></i> Total Revenue
            </h5>
            <p class="card-text">₹<?php echo number_format($total_revenue_in_inr); ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
          <div class="card-body">
            <h5 class="card-title">
              <i class="fas fa-exclamation-circle"></i> Pending Orders
            </h5>
            <p class="card-text"><?php echo number_format($pending_orders); ?></p>
          </div>
        </div>
      </div>
    </div>


    <!-- Graphs Section -->
    <h3>Order Statistics</h3>
    <div class="chart-container">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Orders This Month</h5>
          <canvas id="ordersThisMonth"></canvas>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Orders This Year</h5>
          <canvas id="ordersThisYear"></canvas>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Monthly Income</h5>
          <canvas id="monthlyIncomeChart"></canvas>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">yearly Income</h5>
          <canvas id="yearlyIncomeChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-4">
      <p>&copy; Created by Satabdi Rath. All rights reserved.</p>
    </footer>
  </div>

  <!-- Bootstrap JS and Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
// Get the values from PHP and store them in JavaScript variables
const washFoldCount = <?php echo $wash_fold_count; ?>;
const washIronCount = <?php echo $wash_iron_count; ?>;
const dryCleanCount = <?php echo $dry_clean_count; ?>;

// Dummy data for graphs (replace with dynamic data from PHP)
const ordersThisMonthCtx = document.getElementById('ordersThisMonth').getContext('2d');
const ordersThisYearCtx = document.getElementById('ordersThisYear').getContext('2d');
const monthlyIncomeCtx = document.getElementById('monthlyIncomeChart').getContext('2d');
const yearlyIncomeCtx = document.getElementById('yearlyIncomeChart').getContext('2d');


// Orders This Month Chart with dynamic data
new Chart(ordersThisMonthCtx, {
  type: 'pie',
  data: {
    labels: ['Dry Cleaning', 'Ironing', 'Wash & Fold', 'Folding', 'Stream Ironing', 'Shoe Laundry'],
    datasets: [{
      data: [dryCleanCount, washIronCount, washFoldCount, 1, 1, 1], // Use dynamic data from PHP
      backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ff9f40', '#4bc0c0', '#9966ff'],
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    width: 300,
    height: 300,
    plugins: {
      legend: {
        position: 'left',  // Position the legend to the left
        labels: {
          boxWidth: 20,    // Size of the box for each label
          padding: 10,     // Space between the box and the label text
        },
      }
    }
  }
});

// Orders This Year Chart (Doughnut Chart)
new Chart(ordersThisYearCtx, {
  type: 'doughnut',
  data: {
    labels: ['Dry Cleaning', 'Ironing', 'Wash & Fold', 'Folding', 'Stream Ironing', 'Shoe Laundry'],
    datasets: [{
      data: [dryCleanCount, washIronCount, washFoldCount, 1, 1, 1], // Use dynamic data from PHP
      backgroundColor: ['#ff9f40', '#4bc0c0', '#9966ff', '#ff6384', '#36a2eb', '#cc65fe'],
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    width: 300,
    height: 300,
    plugins: {
      legend: {
        position: 'left',  // Position the legend to the left
        labels: {
          boxWidth: 20,    // Size of the box for each label
          padding: 10,     // Space between the box and the label text
        },
      }
    }
  }
});

new Chart(monthlyIncomeCtx, {
  type: 'line',
  data: {
    labels: serviceTypes,
    datasets: [
      {
        label: 'This Month (₹)',
        data: monthlyIncomeValues,
        borderColor: '#ff6384',
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        fill: true,
        tension: 0.4,
        borderWidth: 3,
      },
      {
        label: 'Previous Month (₹)',
        data: previousMonthlyIncomeValues,
        borderColor: '#36a2eb',
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        fill: true,
        tension: 0.4,
        borderWidth: 3,
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    scales: {
      x: {
        ticks: {
          maxRotation: 45,
          minRotation: 45,
        }
      },
      y: {
        beginAtZero: true,
        position: 'left',
        grid: {
          drawOnChartArea: true,
        },
      },
    },
    animation: {
      duration: 1000,
      easing: 'easeInOutQuad',
    },
    elements: {
      line: {
        borderWidth: 3,
        borderJoinStyle: 'round',
      }
    },
    plugins: {
      legend: {
        position: 'top',
      },
    },
  }
});


new Chart(yearlyIncomeCtx, {
  type: 'line',
  data: {
    labels: serviceTypes,
    datasets: [
      {
        label: 'This Year (₹)',
        data: yearlyIncomeValues,
        borderColor: '#ff9f40',
        backgroundColor: 'rgba(255, 159, 64, 0.2)',
        fill: true,
        tension: 0.4,
        borderWidth: 3,
      },
      {
        label: 'Previous Year (₹)',
        data: previousYearlyIncomeValues,
        borderColor: '#4bc0c0',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        fill: true,
        tension: 0.4,
        borderWidth: 3,
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true,
    scales: {
      x: {
        ticks: {
          maxRotation: 45,
          minRotation: 45,
        }
      },
      y: {
        beginAtZero: true,
        position: 'left',
        grid: {
          drawOnChartArea: true,
        },
      },
    },
    animation: {
      duration: 1000,
      easing: 'easeInOutQuad',
    },
    elements: {
      line: {
        borderWidth: 3,
        borderJoinStyle: 'round',
      }
    },
    plugins: {
      legend: {
        position: 'top',
      },
    },
  }
});




</script>
</body>
</html>

