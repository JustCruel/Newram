<?php
session_start();
include '../config/connection.php';
include 'includes/functions.php';

// Assuming you have the user id in session
if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'Conductor' && $_SESSION['role'] != 'Superadmin')) {
    header("Location: ../index.php");
    exit();
}

$successMessage = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;
$errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;
unset($_SESSION['success_message'], $_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Load User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/sidebars.css">
    <style>
        /* Center the content vertically and horizontally */
        .container-center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full height of the viewport */
        }

       

        .btn-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <?php include "sidebar.php"; ?>

    <div id="main-content" class="container mt-5">
        
            <h1 class="text-center">Load User</h1>

            <div class="mb-4">
                <form id="loadForm" method="POST" onsubmit="return false;">
                    <div class="mb-3">
                        <label for="loadAmount" class="form-label">Enter Load Amount</label>
                        <input type="number" id="loadAmount" name="loadAmount" class="form-control"
                            placeholder="Enter Amount" required>
                    </div>

                    <!-- Predefined buttons for amounts -->
                    <div class="btn-group mb-3" role="group">
                        <button type="button" class="btn btn-secondary load-button" data-amount="100">₱100</button>
                        <button type="button" class="btn btn-secondary load-button" data-amount="200">₱200</button>
                        <button type="button" class="btn btn-secondary load-button" data-amount="500">₱500</button>
                        <button type="button" class="btn btn-secondary load-button" data-amount="1000">₱1000</button>
                    </div>

                    <button type="button" id="scanRFIDBtn" class="btn btn-primary w-100">Scan RFID</button>
                    <input type="hidden" id="user_account_number" name="user_account_number">
                </form>
            </div>
        
    </div>

    <script src="../js/sidebar.js"></script>
    <script>
        // Handle pre-defined load amount buttons
        $(document).on('click', '.load-button', function() {
            const amount = $(this).data('amount');
            const currentAmount = parseFloat($('#loadAmount').val()) || 0;
            $('#loadAmount').val(currentAmount + amount);
        });

        document.getElementById('scanRFIDBtn').addEventListener('click', async () => { 
            try {
                // First, prompt for the user account number
                const { value: userAccountNumber } = await Swal.fire({
                    title: 'Enter Account Number',
                    input: 'text',
                    inputPlaceholder: 'Enter the account number',
                    showCancelButton: true
                });

                // If account number is provided, check if RFID scan is needed
                if (userAccountNumber) {
                    let rfid = userAccountNumber;

                    // If RFID is required, prompt for it
                    if (!userAccountNumber) {
                        const { value: rfidInput } = await Swal.fire({
                            title: 'Scan RFID',
                            input: 'text',
                            inputPlaceholder: 'Enter RFID code',
                            showCancelButton: true
                        });
                        rfid = rfidInput;
                    }

                    const loadAmount = document.getElementById('loadAmount').value;

                    // Confirm the load transaction
                    const { isConfirmed } = await Swal.fire({
                        title: 'Confirm Load',
                        text: `You are about to load ₱${loadAmount} to account number ${userAccountNumber}. Do you want to proceed?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, proceed',
                        cancelButtonText: 'Cancel'
                    });

                    // If confirmed, send the request to load balance
                    if (isConfirmed) {
                        const formData = new FormData();
                        formData.append('loadAmount', loadAmount);
                        formData.append('user_account_number', userAccountNumber);
                        if (rfid) formData.append('rfid', rfid);  // Append RFID if it's available

                        const response = await fetch('includes/load_balance.php', {
                            method: 'POST',
                            body: formData
                        });

                        const result = await response.json();

                        if (result.success) {
                            Swal.fire('Success', `Load successful: ${result.success}`, 'success').then(() => {
                                setTimeout(() => {
                                    location.reload();
                                }, 800); // 2 seconds delay before reload
                            });
                        } else {
                            Swal.fire('Error', result.error, 'error');
                        }
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error', 'There was an error processing your request.', 'error');
            }
        });
    </script>

</body>

</html>
