<?php
session_start();
include '../config/connection.php';

// Check if the user is logged in or has appropriate permissions to access this form
if (!isset($_SESSION['account_number'])) {
    $_SESSION['error_message'] = "You must be logged in to access this page.";
    header('Location: ../users/index.php'); // Redirect to the dashboard or login page
    exit();
}

$accountNumber = $_SESSION['account_number']; // Get account number from the session

// Fetch the user's points from the database
$stmt = $conn->prepare("SELECT points FROM useracc WHERE account_number = ?");
$stmt->bind_param("s", $accountNumber); // "s" for string binding
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    $_SESSION['error_message'] = "User not found.";
    header('Location: ../admin/dashboard.php');
    exit();
}

$availablePoints = $user['points'];

// Fetch account number from the session
$account_number = $_SESSION['account_number'];

// Fetch user balance
$balanceQuery = "SELECT balance FROM useracc WHERE account_number = ?";
$stmt = $conn->prepare($balanceQuery);
$stmt->bind_param('s', $account_number); // Use 's' for string
$stmt->execute();
$stmt->bind_result($balance);
$stmt->fetch();
$stmt->close(); // Close the statement
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convert Points to Balance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/sidebars.css"> <!-- Your custom CSS -->
</head>
<style>
    /* Custom CSS for "Convert Points to Balance" page */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
    }

   


    .card-header {
        font-size: 2.5rem;
        margin-bottom: 20px;
        color: #f1c40f;
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .card-header .card-title {
        font-size: 30px;
        font-weight: 600;
        margin: 0;
    }

    .card-body {
        padding: 20px;
        background-color: #ffffff;
        border-radius: 0 0 10px 10px;
    }

    .form-label {
        font-weight: 500;
        font-size: 16px;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 10px;
    }

    .form-control-plaintext {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 8px;
        font-size: 16px;
        color: #212529;
    }

    .btn {
        background: #f1c40f;
        color: black;
        font-size: 16px;
        font-weight: 500;
        padding: 12px 25px;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    .btn-secondary {
        background: #f1c40f;
        color: white;
        font-size: 16px;
        font-weight: bold;
        padding: 12px 25px;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    .btn-secondary:hover {
        background-color: #f39c12;

    }

    .btn-primary {
        background: rgb(6, 3, 201);
        color: white;
        font-size: 16px;
        font-weight: bold;
        padding: 12px 25px;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #2980b9;

    }

    button+button {
        margin-left: 10px;
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }

    @media (max-width: 576px) {
        .card-header {
            padding: 15px;
        }

        .card-header .card-title {
            font-size: 20px;
        }

        .btn {
            width: 100%;
            margin-top: 10px;
        }

        button+button {
            margin-left: 0;
        }
    }
</style>

<body>
    <?php include 'sidebar.php'; ?>
    <div id="main-content" class="container mt-5">
       
            <div class="card-header">
                <h1 class="card-title">Convert Points to Balance</h1>
            </div>
            <div class="card-body">

                <?php if (isset($_SESSION['success_message'])): ?>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: '<?php echo $_SESSION['success_message'];
                            unset($_SESSION['success_message']); ?>',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    </script>
                <?php endif; ?>

                <?php if (isset($_SESSION['error_message'])): ?>
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: '<?php echo $_SESSION['error_message'];
                            unset($_SESSION['error_message']); ?>',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    </script>
                <?php endif; ?>

                <form id="convertPointsForm">
                    <div class="mb-3">
                        <label class="form-label">Available Points:</label>
                        <p class="form-control-plaintext fw-bold">
                            <?php echo htmlspecialchars($availablePoints); ?>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label for="points" class="form-label">Points to Convert:</label>
                        <input type="number" class="form-control" name="points" id="points" min="1"
                            max="<?php echo htmlspecialchars($availablePoints); ?>" required>
                    </div>
                    <button type="button" class="btn btn-secondary" onclick="inputAllPoints()">Input All Points</button>
                    <button type="button" class="btn btn-primary" onclick="confirmConversion()">Convert Points</button>
                </form>

            </div>
        </div>
    </div>

    <!-- Modal for Updated Balance -->
    <div class="modal fade" id="updatedBalanceModal" tabindex="-1" aria-labelledby="updatedBalanceLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updatedBalanceLabel">Updated Balance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Your new balance is: <strong id="newBalance">₱<?php echo number_format($balance, 2); ?></strong>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        onclick="reloadPage()">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/sidebar.js"></script>

    <script>

        function reloadPage() {
            location.reload();  // This will reload the current page
        }
        function inputAllPoints() {
            var availablePoints = <?php echo $availablePoints; ?>;
            $('#points').val(availablePoints);
        }

        function confirmConversion() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to convert your points!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, convert it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    convertPoints();
                }
            });
        }

        function convertPoints() {
            var pointsToConvert = $('#points').val();
            if (pointsToConvert) {
                $.ajax({
                    url: 'converting_points.php',
                    type: 'POST',
                    data: { points: pointsToConvert },
                    success: function (response) {
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: result.message,
                                timer: 3000,
                                showConfirmButton: false
                            }).then(() => {
                                $('#newBalance').text(result.new_balance);
                                $('#updatedBalanceModal').modal('show');

                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Conversion Failed',
                                text: result.message,
                                timer: 3000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Conversion Failed',
                            text: 'There was an issue converting your points. Please try again.',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Input',
                    text: 'Please enter a valid number of points.',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        }
    </script>
</body>