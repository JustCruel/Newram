<?php
session_start();
ob_start();
include '../config/connection.php';
include 'sidebar.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// Fetch user count
$userCountQuery = "SELECT COUNT(*) as userCount FROM useracc WHERE is_activated = 1";
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCountRow = mysqli_fetch_assoc($userCountResult);
$userCount = $userCountRow['userCount'];

// Fetch users
$userQuery = "SELECT id, firstname, middlename, lastname, birthday, age, gender, address, account_number, balance, province, municipality, barangay 
              FROM useracc WHERE is_activated = 1";
$userResult = mysqli_query($conn, $userQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAMSTAR - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* CSS for scrollable table */
        .table-container {
            max-height: 400px;
            /* Set the height as desired for vertical scrolling */
            max-width: 100%;
            /* Set the width for horizontal scrolling */
            overflow-y: auto;
            /* Enable vertical scrolling */
            overflow-x: auto;
            /* Enable horizontal scrolling */
            position: relative;
            /* Position relative for the header */
        }

        /* Fixed header styles */
        .table thead th {
            position: sticky;
            /* Make header sticky */
            top: 0;
            /* Position at the top of the table */
            background-color: #f8f9fa;
            /* Background color for header */
            z-index: 1;
            /* Ensure it stays above other content */
        }

        /* Ensures the table layout is fixed */
        .table {
            width: 100%;
            /* Full width of the container */
            table-layout: auto;
            /* Change to fixed if needed for consistent column widths */
        }

        /* Styling for Disable button */
        .btn-disable {
            background-color: #dc3545;
            /* Red color */
            color: #ffffff;
            /* White text */
            border: none;
        }

        .btn-disable:hover {
            background-color: #c82333;
            /* Darker red for hover effect */
        }

        /* Styling for Transfer Funds button */
        .btn-transfer {
            background-color: #3CB043;
            /* Amber color */
            color: #000000;
            /* Black text */
            border: none;
        }

        .btn-transfer:hover {
            background-color: #e0a800;
            /* Darker amber for hover effect */
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 main-content">
                <h3 class="mt-3">Registered Users: <?php echo $userCount; ?></h3>

                <!-- Feedback Message -->
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-info">
                        <?php
                        echo $_SESSION['message'];
                        unset($_SESSION['message']); // Clear message after displaying
                        ?>
                    </div>
                <?php endif; ?>

                <!-- Search Form -->
                <form method="POST" action="">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="search" name="search" placeholder="Search users...">
                    </div>
                </form>

                <!-- Table for Displaying Users -->
                <div class="table-container">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Firstname</th>
                                <th>Middlename</th>
                                <th>Lastname</th>
                                <th>Birthday</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th>Province</th>
                                <th>Municipality</th>
                                <th>Barangay</th>
                                <th>Account Number</th>
                                <th>Balance</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            <?php while ($row = mysqli_fetch_assoc($userResult)): ?>
                                <tr id="user-row-<?php echo $row['id']; ?>">
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                                    <td><?php echo htmlspecialchars($row['middlename']); ?></td>
                                    <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                                    <td><?php echo date('F j, Y', strtotime($row['birthday'])); ?></td>
                                    <td><?php echo $row['age']; ?></td>
                                    <td><?php echo htmlspecialchars($row['gender']); ?></td>
                                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                                    <td id="province-<?php echo $row['id']; ?>">
                                        <?php echo htmlspecialchars($row['province']); ?>
                                    </td>
                                    <td id="municipality-<?php echo $row['id']; ?>">
                                        <?php echo htmlspecialchars($row['municipality']); ?>
                                    </td>
                                    <td id="barangay-<?php echo $row['id']; ?>">
                                        <?php echo htmlspecialchars($row['barangay']); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['account_number']); ?></td>
                                    <td>₱<?php echo number_format($row['balance'], 2); ?></td>
                                    <td>
                                        <form id="disableForm<?php echo $row['id']; ?>" method="POST">
                                            <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                            <button type="button" onclick="confirmDisable(<?php echo $row['id']; ?>)"
                                                class="btn btn-disable btn-sm">Disable</button>
                                            <button type="button"
                                                onclick="confirmTransferDisable(<?php echo $row['id']; ?>)"
                                                class="btn btn-transfer btn-sm">Transfer Funds</button>

                                        </form>

                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Load jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            var provinceData = {};
            var municipalityData = {};
            var barangayData = {};

            // Function to fetch provinces
            function fetchProvinces() {
                $.getJSON('https://psgc.gitlab.io/api/provinces/', function (data) {
                    $.each(data, function (index, province) {
                        provinceData[province.code] = province.name; // Map province code to name
                    });
                    updateProvinceNames();
                }).fail(function () {
                    console.error('Failed to fetch province data');
                });
            }

            // Function to update province names in the table
            function updateProvinceNames() {
                $('tbody tr').each(function () {
                    var rowId = $(this).attr('id').split('-')[2];
                    var provinceCode = $('#province-' + rowId).text().trim();

                    // Ensure the province code has 9 digits
                    if (provinceCode.length === 8) {
                        provinceCode = '0' + provinceCode; // Prepend '0' if it has 8 digits
                    }

                    // Update province name based on code
                    if (provinceData[provinceCode]) {
                        $('#province-' + rowId).text(provinceData[provinceCode]);
                    } else {
                        $('#province-' + rowId).text('N/A');
                    }
                });
            }

            // Function to fetch municipalities
            function fetchMunicipalities() {
                $.getJSON('https://psgc.gitlab.io/api/municipalities/', function (data) {
                    $.each(data, function (index, municipality) {
                        municipalityData[municipality.code] = municipality.name; // Map municipality code to name
                    });
                    updateMunicipalityNames();
                }).fail(function () {
                    console.error('Failed to fetch municipality data');
                });
            }

            // Function to update municipality names in the table
            function updateMunicipalityNames() {
                $('tbody tr').each(function () {
                    var rowId = $(this).attr('id').split('-')[2];
                    var municipalityCode = $('#municipality-' + rowId).text().trim();

                    // Ensure the municipality code has 9 digits
                    if (municipalityCode.length === 8) {
                        municipalityCode = '0' + municipalityCode; // Prepend '0' if it has 8 digits
                    }

                    // Update municipality name based on code
                    if (municipalityData[municipalityCode]) {
                        $('#municipality-' + rowId).text(municipalityData[municipalityCode]);
                    } else {
                        $('#municipality-' + rowId).text('N/A');
                    }
                });
            }

            // Function to fetch barangays
            function fetchBarangays() {
                $.getJSON('https://psgc.gitlab.io/api/barangays/', function (data) {
                    $.each(data, function (index, barangay) {
                        barangayData[barangay.code] = barangay.name; // Map barangay code to name
                    });
                    updateBarangayNames();
                }).fail(function () {
                    console.error('Failed to fetch barangay data');
                });
            }

            // Function to update barangay names in the table
            function updateBarangayNames() {
                $('tbody tr').each(function () {
                    var rowId = $(this).attr('id').split('-')[2];
                    var barangayCode = $('#barangay-' + rowId).text().trim();

                    // Ensure the barangay code has 9 digits
                    if (barangayCode.length === 8) {
                        barangayCode = '0' + barangayCode; // Prepend '0' if it has 8 digits
                    }

                    // Update barangay name based on code
                    if (barangayData[barangayCode]) {
                        $('#barangay-' + rowId).text(barangayData[barangayCode]);
                    } else {
                        $('#barangay-' + rowId).text('N/A');
                    }
                });
            }

            // Fetch all data
            fetchProvinces();
            fetchMunicipalities();
            fetchBarangays();
        });



        function confirmTransferDisable(userId) {
            Swal.fire({
                title: 'Enter New Account Number',
                input: 'text',
                inputLabel: 'New Account Number for Fund Transfer',
                inputPlaceholder: 'Enter account number...',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Please enter a new account number!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const newAccountNumber = result.value;

                    // Send AJAX request to disable the user and transfer funds
                    $.ajax({
                        url: 'transfer_and_disabled.php',
                        method: 'POST',
                        data: { user_id: userId, new_account_number: newAccountNumber },
                        success: function (response) {
                            const result = JSON.parse(response);
                            if (result.success) {
                                $('#userTableBody').html(result.tableData);
                                Swal.fire('Disabled!', 'User has been disabled and funds transferred.', 'success').then(() => {
                                    // Reload the page after the alert is closed
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error!', result.message, 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Error!', 'There was an error disabling the user.', 'error');
                        }
                    });
                }
            });
        }

        function confirmDisable(userId) {
            Swal.fire({
                title: 'Disabled Account?',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    const newAccountNumber = result.value;

                    // Send AJAX request to disable the user and transfer funds
                    $.ajax({
                        url: 'disable_user_only.php',
                        method: 'POST',
                        data: { user_id: userId, new_account_number: newAccountNumber },
                        success: function (response) {
                            const result = JSON.parse(response);
                            if (result.success) {

                                Swal.fire('Disabled!', 'User has been disabled', 'success').then(() => {
                                    // Reload the page after the alert is closed
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error!', result.message, 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Error!', 'There was an error disabling the user.', 'error');
                        }
                    });
                }
            });
        }


        // jQuery and AJAX Script for Live Search
        $(document).ready(function () {
            $('#search').on('keyup', function () {
                var query = $(this).val();

                $.ajax({
                    url: 'search_users.php',
                    method: 'POST',
                    data: { query: query },
                    success: function (data) {
                        $('#userTableBody').html(data);
                    }
                });
            });
        });
    </script>
</body>

</html>