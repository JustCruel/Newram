<?php
session_start();
include '../config/connection.php';

if (!isset($_SESSION['email']) || ($_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'Superadmin')) {
    header("Location: ../index.php");
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to log activities
function logActivity($conn, $user_id, $action, $performed_by)
{
    $logQuery = "INSERT INTO activity_logs (user_id, action, performed_by) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($logQuery);
    $stmt->bind_param("iss", $user_id, $action, $performed_by);
    $stmt->execute();
    $stmt->close();
}

// Activate user action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id']; // Get the user ID from the POST data

    if ($user_id) {
        // Prepare the SQL statement to prevent SQL injection
        $activateQuery = "UPDATE useracc SET is_activated = 1 WHERE id = ?"; // Set is_activated to 1
        $stmt = $conn->prepare($activateQuery);

        if ($stmt) {
            $stmt->bind_param("i", $user_id); // Bind the user ID as an integer parameter
            if ($stmt->execute()) {
                // Log the activity
                logActivity($conn, $user_id, 'Activated', $_SESSION['firstname'] . ' ' . $_SESSION['lastname']);

                // Fetch the updated list of users
                $userQuery = "SELECT id, firstname, middlename, lastname, birthday, age, gender, address, province, municipality, barangay, account_number, balance 
                              FROM useracc WHERE is_activated = 0"; // Fetch only activated users
                $userResult = mysqli_query($conn, $userQuery);

                $updatedTableData = ''; // Initialize updated table data

                // Build the updated table rows
                while ($row = mysqli_fetch_assoc($userResult)) {
                    $updatedTableData .= '<tr>
                        <td>' . htmlspecialchars($row['id']) . '</td>
                        <td>' . htmlspecialchars($row['firstname']) . '</td>
                        <td>' . htmlspecialchars($row['middlename']) . '</td>
                        <td>' . htmlspecialchars($row['lastname']) . '</td>
                        <td>' . date('F j, Y', strtotime($row['birthday'])) . '</td>
                        <td>' . htmlspecialchars($row['age']) . '</td>
                        <td>' . htmlspecialchars($row['gender']) . '</td>
                        <td>' . htmlspecialchars($row['address']) . '</td>
                        <td>' . htmlspecialchars($row['province']) . '</td>
                        <td>' . htmlspecialchars($row['municipality']) . '</td>
                        <td>' . htmlspecialchars($row['barangay']) . '</td>
                        <td>' . htmlspecialchars($row['account_number']) . '</td>
                        <td>₱' . number_format($row['balance'], 2) . '</td>
                        <td>
                            <form id="activateForm' . $row['id'] . '" method="POST">
                                <input type="hidden" name="user_id" value="' . $row['id'] . '">
                                <button type="button" onclick="confirmActivate(' . $row['id'] . ')" class="btn btn-success btn-sm">Activate</button>
                            </form>
                        </td>
                    </tr>';
                }

                // Return the updated table rows as a JSON response
                echo json_encode(['success' => true, 'tableData' => $updatedTableData]);
            } else {
                echo json_encode(['success' => false, 'message' => "Error activating user: " . $stmt->error]);
            }
            $stmt->close(); // Close the statement
        } else {
            echo json_encode(['success' => false, 'message' => "Error preparing statement: " . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => "User  ID is missing."]);
    }
    exit;
}
?>