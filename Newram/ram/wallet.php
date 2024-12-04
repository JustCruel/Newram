<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: log-in.php");
    exit;
}

// Include database connection
include 'config/connection.php';
include 'sidebar.php';

// Fetch the user's balance from the database
$email = $_SESSION['email'];
$sql = "SELECT balance, firstname, lastname FROM users1 WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($balance, $firstname, $lastname);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wallet</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .wallet-card {
            background: linear-gradient(45deg, #007bff, #6610f2);
            color: white;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            margin-left: 250px;
            /* Adjust this value to match your sidebar width */
            padding: 20px;
        }
    </style>
</head>

<body>


    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="card wallet-card mb-4">
                        <div class="card-body">
                            <h3 class="card-title">Welcome,
                                <?php echo htmlspecialchars($firstname . ' ' . $lastname); ?>
                            </h3>
                            <h4 class="card-subtitle mb-2">Your Balance</h4>
                            <h2 class="display-4">₱<?php echo number_format($balance, 2); ?></h2>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <a href="wheretoload.php" class="btn btn-primary btn-lg w-100 mb-2">
                                <i class="fas fa-money-bill-wave me-2"></i> Where to Load
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="transaction.php" class="btn btn-success btn-lg w-100 mb-2">
                                <i class="fas fa-exchange-alt me-2"></i> transactions
                            </a>
                        </div>
                    </div>

</html>