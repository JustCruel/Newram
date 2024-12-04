<?php
session_start();
ob_start(); // Start output buffering
include '../config/connection.php';

// Redirect to login if not authenticated




// Fetch user count
$userCountQuery = "SELECT COUNT(*) as userCount FROM users1 WHERE is_activated = 1"; // Fetch activated users
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCountRow = mysqli_fetch_assoc($userCountResult);
$userCount = $userCountRow['userCount'];

// Disable user action
if (isset($_POST['disable_user'])) {
    $user_id = $_POST['user_id']; // Get the user ID from the form

    if ($user_id) {
        $disableQuery = "UPDATE users1 SET is_activated = 0 WHERE id = ?";
        $stmt = $conn->prepare($disableQuery);
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            if ($stmt->execute()) {
                // Success
                $_SESSION['message'] = "User disabled successfully.";
            } else {
                // Error executing statement
                $_SESSION['message'] = "Error disabling user.";
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

// Activate user action
if (isset($_POST['activate_user'])) {
    $user_id = $_POST['user_id']; // Get the user ID from the form

    if ($user_id) {
        $activateQuery = "UPDATE users1 SET is_activated = 1 WHERE id = ?";
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
$recentUsersQuery = "SELECT * FROM users1 WHERE is_activated = 0 ORDER BY created_at DESC"; // Adjusted to fetch non-activated users
$recentUsersResult = mysqli_query($conn, $recentUsersQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAMSTAR - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css"> <!-- Your custom CSS -->
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

        .dashboard-item {
            background-color: rgb(87, 107, 237);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin: 20px;
        }

        .dashboard-item h3 {
            color: #4caf50;
        }

        .dashboard-item p {
            font-size: 20px;
            color: #333;
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
        <h3>Registered Users: <?php echo $userCount; ?></h3>

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
        <h3>Recently Registered Accounts (Awaiting Activation)</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Firstname</th>
                    <th>Middlename</th>
                    <th>Lastname</th>
                    <th>Account Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($recentUsersResult)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['firstname']; ?></td>
                        <td><?php echo $row['middlename']; ?></td>
                        <td><?php echo $row['lastname']; ?></td>
                        <td><?php echo $row['account_number']; ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="activate_user" class="btn btn-success">Activate</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Confirmation Script -->
    <script>
        function confirmDisable() {
            return confirm("Do you really want to disable this user?");
        }
    </script>

    <!-- jQuery and AJAX Script for Live Search -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#search').on('keyup', function () {
                var query = $(this).val();

                $.ajax({
                    url: 'search_users.php',
                    method: 'POST',
                    data: { query: query },
                    success: function (data) {
                        $('#userTableBody').html(data); // Update the table body with the search results
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