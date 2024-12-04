<?php
session_start();
include '../config/connection.php'; // Include your database connection

$user = null;
$error = null;
$success = null;

// Check if the request is POST and handle the RFID input
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rfid'])) {
    $rfid_code = trim($_POST['rfid']);

    $stmt = $conn->prepare("SELECT id, firstname, lastname, balance FROM user WHERE account_number = ?");
    $stmt->bind_param("s", $rfid_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode(['success' => true, 'data' => $user]);
        exit; // Prevent further output
    } else {
        echo json_encode(['success' => false, 'error' => 'RFID not found.']);
        exit; // Prevent further output
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search User Info</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- For alert dialogs -->
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Search User Info</h1>
    <!-- Form to scan RFID -->
    <form id="searchUserForm" class="mt-4">
        <div class="form-group">
            <label for="rfid">Scan RFID:</label>
            <input type="text" class="form-control mb-3" id="rfid" name="rfid" autofocus required>
        </div>
    </form>

    <div id="userInfo" style="display: <?php echo $user ? 'block' : 'none'; ?>;">
        <div class="card">
            <h2 class="text-center">User Info</h2>
            <p><strong>Name:</strong> <span id="userName"><?php echo isset($user) ? htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) : ''; ?></span></p>
            <p><strong>Current Balance:</strong> P<span id="userBalance"><?php echo isset($user) ? number_format($user['balance'], 2) : '0.00'; ?></span></p>
            <p><strong>Card Status:</strong> Active</p>

            <!-- Load Balance Form -->
            <form method="POST" class="mt-4" id="loadBalanceAmountForm">
                <input type="hidden" name="rfid" value="<?php echo isset($rfid_code) ? htmlspecialchars($rfid_code) : ''; ?>">
                <div class="form-group">
                    <label for="amount">Amount to Load:</label>
                    <input type="number" class="form-control mb-3" id="amount" name="amount" min="1" required>
                </div>

                <!-- Predefined amount buttons -->
                <div class="text-center mb-3">
                    <?php 
                    $amounts = [50, 100, 150, 200, 250, 300, 350, 400, 450, 500, 550, 600, 650, 700, 750, 800, 850, 900, 950, 1000]; // Predefined amounts
                    foreach ($amounts as $amount): ?>
                        <button type="button" class="btn btn-primary m-1" onclick="setAmount(<?php echo $amount; ?>)"><?php echo $amount; ?></button>
                    <?php endforeach; ?>
                </div>

                <button type="button" class="btn btn-success btn-block" id="confirmLoadBalance">Load Balance</button>
            </form>

            <!-- Deduct Balance Form -->
            <form method="POST" class="mt-4" id="deductBalanceAmountForm">
                <input type="hidden" name="rfid" value="<?php echo isset($rfid_code) ? htmlspecialchars($rfid_code) : ''; ?>">
                <div class="form-group">
                    <label for="deduct_amount">Amount to Deduct:</label>
                    <input type="number" class="form-control mb-3" id="deduct_amount" name="deduct_amount" min="1" required>
                </div>

                <button type="button" class="btn btn-danger btn-block" id="confirmDeductBalance">Deduct Balance</button>
            </form>

            <?php if (isset($success)): ?>
                <div class="alert alert-success text-center"><?php echo $success; ?></div>
            <?php elseif (isset($error)): ?>
                <div class="alert alert-danger text-center"><?php echo $error; ?></div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (isset($error)): ?>
        <div id="errorMsg" style="display: block;" class="alert alert-danger mt-3 text-center"><?php echo $error; ?></div>
    <?php else: ?>
        <div id="errorMsg" style="display: none;" class="alert alert-danger mt-3 text-center"></div>
    <?php endif; ?>
</div>

<script>
$(document).ready(function() {
    $('#rfid').on('input', function() {
        const rfidCode = $(this).val();
        
        // Only submit if the RFID code length is valid (e.g., 10)
        if (rfidCode.length === 10) {
            $.ajax({
                url: 'includes/search_user.php', // Adjust the path as necessary
                type: 'POST',
                data: { rfid: rfidCode },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#userInfo').show();
                        $('#errorMsg').hide();
                        $('#userName').text(response.data.firstname + ' ' + response.data.lastname);
                        $('#userBalance').text(parseFloat(response.data.balance).toFixed(2));
                    } else {
                        $('#errorMsg').text(response.error).show();
                        $('#userInfo').hide();
                    }
                },
                error: function() {
                    $('#errorMsg').text('An unexpected error occurred.').show();
                    $('#userInfo').hide();
                }
            });
        }
    });

    // Function to set predefined amount
    window.setAmount = function(amount) {
        document.getElementById('amount').value = amount;
    };

    // Load Balance confirmation and handling
    document.getElementById('confirmLoadBalance').addEventListener('click', function() {
        const amount = document.getElementById('amount').value;

        if (!amount || amount <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Amount',
                text: 'Please enter a valid amount to load.',
                confirmButtonText: 'OK'
            });
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to load P${amount} to this account.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, load it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData(document.getElementById('loadBalanceAmountForm'));
                formData.append('load_amount', true); // Indicate that this is a load balance request

                fetch('load_balance.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.success,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload(); // Reloads the page
                        });
                    } else if (data.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.error,
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An unexpected error occurred.',
                        confirmButtonText: 'OK'
                    });
                });
            }
        });
    });

    // Deduct Balance confirmation and handling
    document.getElementById('confirmDeductBalance').addEventListener('click', function() {
        const amount = document.getElementById('deduct_amount').value;

        if (!amount || amount <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Amount',
                text: 'Please enter a valid amount to deduct.',
                confirmButtonText: 'OK'
            });
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to deduct P${amount} from this account.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, deduct it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData(document.getElementById('deductBalanceAmountForm'));
                formData.append('deduct_amount', true); // Indicate that this is a deduct balance request

                fetch('deduct_balance.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.success,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload(); // Reloads the page
                        });
                    } else if (data.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.error,
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An unexpected error occurred.',
                        confirmButtonText: 'OK'
                    });
                });
            }
        });
    });
});
</script>
</body>
</html>
