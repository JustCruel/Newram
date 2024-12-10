<?php
session_start();
ob_start();
include '../config/connection.php';
include '../sidebar.php';

if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'Superadmin')) {
    header("Location: ../index.php");
    exit();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            background-color: #f0f0f0;
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff;
            padding: 20px;
            color: #001f3f;
            border-right: 1px solid #e0e0e0;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #ffffff;
            overflow-y: auto;
            border-left: 1px solid #e0e0e0;
        }

        h3 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .table-container {
            max-height: 400px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .btn-disable {
            background-color: #dc3545;
            color: #ffffff;
            border: none;
        }

        .btn-disable:hover {
            background-color: #c82333;
        }

        .btn-transfer {
            background-color: #3CB043;
            color: #000000;
            border: none;
        }

        .btn-transfer:hover {
            background-color: #e0a800;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 150px;
            }
        }
    </style>
</head>

<body>
    <div class="main-content">
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

        <!-- Table for Displaying Users -->
        <div class="table-container">
            <form method="POST" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="search" name="search" placeholder="Search users...">
                </div>
            </form>
            <table class="table table-striped">
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
                                    <button type="button" onclick="confirmTransferDisable(<?php echo $row['id']; ?>)"
                                        class="btn btn-transfer btn-sm">Transfer Funds</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            var provinceData = {};
            var municipalityData = {};
            var barangayData = {};

            function fetchProvinces() {
                $.getJSON('https://psgc.gitlab.io/api/provinces/', function (data) {
                    $.each(data, function (index, province) {
                        provinceData[province.code] = province.name;
                    });
                    updateProvinceNames();
                }).fail(function () {
                    console.error('Failed to fetch province data');
                });
            }

            function updateProvinceNames() {
                $('tbody tr').each(function () {
                    var rowId = $(this).attr('id').split('-')[2];
                    var provinceCode = $('#province-' + rowId).text().trim();
                    if (provinceCode.length === 8) {
                        provinceCode = '0' + provinceCode;
                    }
                    $('#province-' + rowId).text(provinceData[provinceCode] || 'N/A');
                });
            }

            function fetchMunicipalities() {
                $.getJSON('https://psgc.gitlab.io/api/municipalities/', function (data) {
                    $.each(data, function (index, municipality) {
                        municipalityData[municipality.code] = municipality.name;
                    });
                    updateMunicipalityNames();
                }).fail(function () {
                    console.error('Failed to fetch municipality data');
                });
            }

            function updateMunicipalityNames() {
                $('tbody tr').each(function () {
                    var rowId = $(this).attr('id').split('-')[2];
                    var municipalityCode = $('#municipality-' + rowId).text().trim();
                    if (municipalityCode.length === 8) {
                        municipalityCode = '0' + municipalityCode;
                    }
                    $('#municipality-' + rowId).text(municipalityData[municipalityCode] || 'N/A');
                });
            }

            function fetchBarangays() {
                $.getJSON('https://psgc.gitlab.io/api/barangays/', function (data) {
                    $.each(data, function (index, barangay) {
                        barangayData[barangay.code] = barangay.name;
                    });
                    updateBarangayNames();
                }).fail(function () {
                    console.error('Failed to fetch barangay data');
                });
            }

            function updateBarangayNames() {
                $('tbody tr').each(function () {
                    var rowId = $(this).attr('id').split('-')[2];
                    var barangayCode = $('#barangay-' + rowId).text().trim();
                    if (barangayCode.length === 8) {
                        barangayCode = '0' + barangayCode;
                    }
                    $('#barangay-' + rowId).text(barangayData[barangayCode] || 'N/A');
                });
            }

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
                    $.ajax({
                        url: 'transfer_and_disabled.php',
                        method: 'POST',
                        data: { user_id: userId, new_account_number: newAccountNumber },
                        success: function (response) {
                            const result = JSON.parse(response);
                            if (result.success) {
                                $('#userTableBody').html(result.tableData);
                                Swal.fire('Disabled!', 'User  has been disabled and funds transferred.', 'success').then(() => {
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
                    $.ajax({
                        url: 'disable_user_only.php',
                        method: 'POST',
                        data: { user_id: userId },
                        success: function (response) {
                            const result = JSON.parse(response);
                            if (result.success) {
                                Swal.fire('Disabled!', 'User  has been disabled', 'success').then(() => {
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