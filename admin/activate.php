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
$userCountQuery = "SELECT COUNT(*) as userCount FROM useracc WHERE is_activated = 0"; // Count only non-activated users
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
$recentUsersQuery = "SELECT * FROM useracc WHERE is_activated = 0 ORDER BY created_at DESC"; // Fetch non-activated users
$recentUsersResult = mysqli_query($conn, $recentUsersQuery);
$userQuery = "SELECT id, firstname, middlename, lastname, birthday, age, gender, address, account_number, balance, province, municipality, barangay 
              FROM useracc WHERE is_activated = 0";
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
    <div id="content" class="p-4 p-md-5">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-primary" onclick="toggleSidebar(event)">
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
                        <li class="nav-item active">
                            <a class="nav-link" href="#" onclick="loadContent('home.php');">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Portfolio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="main-content">
            <h3>Registered Users Awaiting Activation: <?php echo $userCount; ?></h3>

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
                                    <form id="activateForm<?php echo $row['id']; ?>" method="POST">
                                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                        <button type="button" onclick="confirmActivate(<?php echo $row['id']; ?>)"
                                            class="btn btn-success btn-sm">Activate</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Confirmation Script -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
        <script>
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
                                    // Update the user table body with the new rows
                                    $('#userTableBody').html(result.tableData);
                                    Swal.fire('Activated!', 'User has been activated.', 'success');
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
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
ob_end_flush(); // End output buffering
?>