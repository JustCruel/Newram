<?php
session_start();
include 'config/connection.php';

// Fetch user count
$userCountQuery = "SELECT COUNT(*) as userCount FROM users";
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCountRow = mysqli_fetch_assoc($userCountResult);
$userCount = $userCountRow['userCount'];

$totalRevenueQuery = "SELECT SUM(amount) as totalRevenue FROM revenue WHERE transaction_type = 'debit'";
$totalRevenueResult = mysqli_query($conn, $totalRevenueQuery);
$totalRevenueRow = mysqli_fetch_assoc($totalRevenueResult);
$totalRevenue = $totalRevenueRow['totalRevenue'] ?? 0;
// Initialize search variables
$searchResult = null;
$searchError = null;

// Handle search request
if (isset($_POST['search_id'])) {
  $userId = mysqli_real_escape_string($conn, $_POST['user_id']);

  if (!empty($userId)) {
    $searchQuery = "SELECT * FROM users WHERE id = '$userId'";
    $searchResult = mysqli_query($conn, $searchQuery);

    if (mysqli_num_rows($searchResult) == 0) {
      $searchError = "No user found with ID: $userId";
    }
  } else {
    $searchError = "Please enter a user ID.";
  }
}

// Handle balance loading
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_account_number']) && isset($_POST['balance'])) {
  $userAccountNumber = mysqli_real_escape_string($conn, $_POST['user_account_number']);
  $balanceToLoad = mysqli_real_escape_string($conn, $_POST['balance']);

  // Update the user's balance in the database
  $updateBalanceQuery = "UPDATE users SET balance = balance + '$balanceToLoad' WHERE account_number = '$userAccountNumber'";
  if (mysqli_query($conn, $updateBalanceQuery)) {
    $_SESSION['success_message'] = 'Balance loaded successfully!';
  } else {
    $_SESSION['error_message'] = 'Error loading balance: ' . mysqli_error($conn);
  }

  // Redirect to the same page to avoid resubmission
  header("Location: " . $_SERVER['PHP_SELF']);
  exit;
}

// Initialize alerts
$successMessage = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;
$errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;
$loginSuccessMessage = isset($_SESSION['login_success']) ? $_SESSION['login_success'] : null;

// Clear messages after displaying
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);
unset($_SESSION['login_success']);
?>

<!doctype html>
<html lang="en">

<head>
  <title>Administrator Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
  <div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar" class="active">
      <h1><a href="index.html" class="logo">M.</a></h1>
      <ul class="list-unstyled components mb-5">
        <li class="active"><a href="#"><span class="fa fa-home"></span> Home</a></li>
        <li><a href="#"><span class="fa fa-user"></span> About</a></li>
        <li><a href="#"><span class="fa fa-sticky-note"></span> Blog</a></li>
        <li><a href="#"><span class="fa fa-cogs"></span> Services</a></li>
        <li><a href="#"><span class="fa fa-paper-plane"></span> Contacts</a></li>
      </ul>
      <div class="footer">
        <p>Copyright &copy;
          <script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i
            class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com"
            target="_blank">Colorlib.com</a>
        </p>
      </div>
    </nav>

    <!-- Page Content -->
    <div id="content" class="p-4 p-md-5">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Toggle Menu</span>
          </button>
          <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
              <li class="nav-item active"><a class="nav-link" href="#">Home</a></li>
              <li class="nav-item"><a class="nav-link" href="#">About</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Portfolio</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
            </ul>
          </div>
        </div>
      </nav>

      <h2 class="mb-4">Administrator Dashboard</h2>

      <?php if (isset($searchError)): ?>
        <div class="alert alert-danger">
          <?php echo $searchError; ?>
        </div>
      <?php endif; ?>

      <?php if (isset($searchResult) && mysqli_num_rows($searchResult) > 0): ?>
        <div class="search-results">
          <h3>Search Results:</h3>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Account Number</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($user = mysqli_fetch_assoc($searchResult)): ?>
                <tr>
                  <td>
                    <?php echo htmlspecialchars($user['firstname']); ?>
                  </td>
                  <td>
                    <?php echo htmlspecialchars($user['lastname']); ?>
                  </td>
                  <td>
                    <?php echo htmlspecialchars($user['account_number']); ?>
                  </td>
                  <td>
                    <button class="btn btn-secondary btn-sm"
                      onclick="loadUser('<?php echo htmlspecialchars($user['account_number']); ?>')">Load</button>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>

      <div class="dashboard">
        <div class="dashboard-item">
          <i class="fas fa-users"></i>
          <h3>Registered Users</h3>
          <p>
            <?php echo $userCount; ?>
          </p>
        </div>
        <div class="dashboard-item">
          <i class="fas fa-desktop"></i>
          <h3>Total Terminals</h3>
          <!-- <p><?php echo $totalTerminals; ?></p> -->
        </div>
        <div class="dashboard-item">
          <i class="fas fa-money-bill-wave"></i>
          <h3>Total Revenue</h3>
          <p>₱
            <?php echo number_format($totalRevenue, 2); ?>
          </p>
        </div>
        <div class="dashboard-item">
          <i class="fas fa-car"></i>
          <h3>Total Bus</h3>
          <!--  <p><?php echo $totalVehicles; ?></p> -->
        </div>
      </div>

      <!-- Modal for Loading Balance -->
      <div class="modal fade" id="loadBalanceModal" tabindex="-1" aria-labelledby="loadBalanceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="loadBalanceModalLabel">Load Balance</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="loadBalanceForm" method="POST">
                <input type="hidden" name="user_account_number" id="user_account_number">
                <div class="mb-3">
                  <label for="balance" class="form-label">Balance Amount</label>
                  <input type="number" class="form-control" name="balance" id="balance" required>
                </div>
                <button type="submit" class="btn btn-primary">Load Balance</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Balance Load Form -->
      <div class="balance-load">
        <h3>Load User Balance</h3>
        <form method="POST" action="">
          <div class="mb-3">
            <label for="user_id" class="form-label">User ID</label>
            <input type="text" class="form-control" name="user_id" id="user_id" required>
          </div>
          <button type="submit" class="btn btn-primary">Search</button>
        </form>
      </div>

      <script>
        function loadUser(accountNumber) {
          document.getElementById('user_account_number').value = accountNumber;
          var modal = new bootstrap.Modal(document.getElementById('loadBalanceModal'));
          modal.show();
        }
      </script>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>