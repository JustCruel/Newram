<?php
session_start();
ob_start(); // Start output buffering
include '../config/connection.php';


if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'Superadmin')) {
    header("Location: ../index.php");
    exit();
}

// Assuming you have the user id in session
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];

// Fetch user data
$query = "SELECT firstname, lastname FROM useracc WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($firstname, $lastname);
$stmt->fetch();



// Fetch user count
$userActivateCountQuery = "SELECT COUNT(*) as userActivateCount FROM useracc WHERE is_activated = 0"; // Count only non-activated users
$userActivateCountResult = mysqli_query($conn, $userActivateCountQuery);
$userActivateCountRow = mysqli_fetch_assoc($userActivateCountResult);
$userActivateCount = $userActivateCountRow['userActivateCount'];

// Fetch user count
$userCountQuery = "SELECT COUNT(*) as userCount FROM useracc WHERE is_activated = 1";
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCountRow = mysqli_fetch_assoc($userCountResult);
$userCount = $userCountRow['userCount'];


// Activate user action
if (isset($_POST['activate_user'])) {
    $user_id = $_POST['user_id']; // Get the user ID from the form

    if ($user_id) {
        $activateQuery = "UPDATE useracc SET is_activated = 1 WHERE id = ?";
        $stmt = $conn->prepare($activateQuery);
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            if ($stmt->execute()) {
                // Success
                $_SESSION['message'] = "User activated successfully.";
            } else {
                // Error executing statement
                $_SESSION['message'] = "Error activating user.";
            }
            $stmt->close();
        } else {
            // Error preparing statement
            $_SESSION['message'] = "Error preparing statement.";
        }
    } else {
        $_SESSION['message'] = "User ID is missing.";
    }
    header("Location: users.php"); // Redirect to refresh the page
    exit;
}

// Fetch recently registered users
$recentUsersQuery = "SELECT * FROM useracc ORDER BY created_at DESC"; // Fetch non-activated users
$recentUsersResult = mysqli_query($conn, $recentUsersQuery);
$userQuery = "SELECT id, firstname, middlename, lastname, birthday, age, gender, address, account_number, balance, province, municipality, barangay, is_activated 
              FROM useracc";

$userResult = mysqli_query($conn, $userQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAMSTAR - Admin Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
    <?php
    include "../sidebar.php";
    ?>

    <!-- Page Content  -->

    <div class="main-content">
        <h3>
            Registered Users Awaiting Activation: <?php echo $userActivateCount; ?> Registered Users:
            <?php echo $userCount; ?>
        </h3>


        <form method="POST" action="">
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="search" name="search" placeholder="Search users...">
            </div>
        </form>
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
                        <th>Status</th>
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
                            <td> <?php echo isset($row['is_activated']) ? ($row['is_activated'] == 1 ? 'Activated' : 'Disabled') : 'N/A'; ?>
                            </td>
                            <td>
                                <form id="actionForm<?php echo $row['id']; ?>" method="POST">
                                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#actionModal"
                                        onclick="prepareActions(<?php echo $row['id']; ?>, <?php echo $row['is_activated']; ?>)">
                                        Action
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- Action Modal -->
    <div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="actionModalLabel">User Actions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <button id="activateBtn" class="btn btn-success btn-sm"
                        onclick="confirmActivate()">Activate</button>
                    <button id="disableBtn" class="btn btn-danger btn-sm" onclick="confirmDisable()">Disable</button>
                    <button id="transferFundsBtn" class="btn btn-warning btn-sm"
                        onclick="confirmTransferDisable()">Transfer
                        Funds</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Confirmation Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        function prepareActions(userId, isActivated) {
            // Store the user ID in the modal
            $('#actionModal').data('userId', userId);

            // Enable or disable the buttons based on the user's status
            if (isActivated == 1) {
                $('#activateBtn').prop('disabled', true); // Disable 'Activate' if the user is already activated
                $('#disableBtn').prop('disabled', false); // Enable 'Disable' if the user is activated
            } else {
                $('#activateBtn').prop('disabled', false); // Enable 'Activate' if the user is not activated
                $('#disableBtn').prop('disabled', false); // Enable 'Disable' if the user is not activated
            }
        }


        function toggleSidebar(event) {
            event.preventDefault(); // Prevent default action when clicking toggle button
            $('#sidebar').toggleClass('active');
        }

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


        function confirmActivate(userId) {

            var userId = $('#actionModal').data('userId'); // Get the stored user ID

            // Set the user_id in the hidden form input for submitting
            $('#actionForm').find('input[name="user_id"]').val(userId);

            // Submit the form to activate the user
            $('#actionForm').submit();
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to activate this user?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, activate it!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to activate the user
                    $.ajax({
                        url: 'activate_user.php', // Ensure this points to your activate.php
                        method: 'POST',
                        data: { user_id: userId }, // Send user ID
                        success: function (response) {
                            const result = JSON.parse(response); // Parse the JSON response
                            if (result.success) {
                                Swal.fire('Disabled!', 'User  has been activated', 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error!', result.message, 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Error!', 'There was an error activating the user.', 'error');
                        }
                    });
                }
            });
        }

        function confirmTransferDisable(userId) {
            var userId = $('#actionModal').data('userId'); // Get the stored user ID

            // Set the user_id in the hidden form input for submitting
            $('#actionForm').find('input[name="user_id"]').val(userId);

            // Submit the form to activate the user
            $('#actionForm').submit();
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
            var userId = $('#actionModal').data('userId'); // Get the stored user ID

            // Set the user_id in the hidden form input for submitting
            $('#actionForm').find('input[name="user_id"]').val(userId);

            // Submit the form to activate the user
            $('#actionForm').submit();
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

<?php
ob_end_flush(); // End output buffering
?>