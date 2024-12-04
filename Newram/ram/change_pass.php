<?php
session_start(); // Start the session
include "config/connection.php";
include "sidebar.php";

// Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // Redirect to login if not authenticated
    exit();
}

// Get the user_id from the session
$user_id = $_SESSION['id']; // Get user ID from session

// Initialize validation messages
$swalMessage = '';
$password_requirements_message = '';
$password_match_message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the new password and confirm password match
    if ($new_password !== $confirm_password) {
        $password_match_message = "New password and confirm password do not match.";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $new_password)) {
        $password_requirements_message = "New password must have at least 1 capital letter, 1 number, 1 special character, and be at least 8 characters long.";
    } else {
        // Fetch the user's current hashed password from the database
        $stmt = $conn->prepare("SELECT password FROM users1 WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($current_hashed_password);
        $stmt->fetch();
        $stmt->close();

        // Verify the old password
        if (md5($old_password) === $current_hashed_password) {
            // Hash the new password
            $hashed_new_password = md5($new_password);

            // Update the password in the database
            $update_stmt = $conn->prepare("UPDATE users1 SET password = ? WHERE id = ?");
            $update_stmt->bind_param("si", $hashed_new_password, $user_id);

            if ($update_stmt->execute()) {
                $swalMessage = "success|Password updated successfully.";
            } else {
                $swalMessage = "error|Error updating password: " . $update_stmt->error;
            }

            $update_stmt->close();
        } else {
            $swalMessage = "error|Old password is incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Change Password</title>
    <style>
        body {
            background-color: #f7f7f7;
            font-family: Arial, sans-serif;
        }

        .form-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-label {
            color: blue;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #cc0000;
            border-color: #cc0000;
            color: white;
            font-weight: bold;
            padding: 10px;
        }

        .btn-primary:hover {
            background-color: #ffcc00;
            border-color: #ffcc00;
            color: blue;
        }

        .password-requirements {
            font-size: 0.9rem;
            color: grey;
        }

        .requirement {
            list-style: none;
            padding-left: 0;
            font-size: 0.9rem;
        }

        .requirement li {
            color: red;
            /* Default color for unmet requirements */
        }

        .requirement li.valid {
            color: green;
            /* Color for met requirements */
        }
    </style>
    <script>
        $(document).ready(function () {
            const requirements = {
                capitalLetter: false,
                number: false,
                specialCharacter: false,
                length: false
            };

            const updateRequirements = () => {
                const password = $("#new_password").val();

                // Show/hide the requirements based on input
                if (password.length === 0) {
                    $(".requirement").hide(); // Hide when input is empty
                } else {
                    $(".requirement").show(); // Show when typing
                }

                // Check for each requirement
                requirements.capitalLetter = /[A-Z]/.test(password);
                requirements.number = /\d/.test(password);
                requirements.specialCharacter = /[\W_]/.test(password);
                requirements.length = password.length >= 8;

                // Update requirement UI
                $(".requirement li").each(function (index) {
                    switch (index) {
                        case 0:
                            $(this).toggleClass("valid", requirements.capitalLetter);
                            break;
                        case 1:
                            $(this).toggleClass("valid", requirements.number);
                            break;
                        case 2:
                            $(this).toggleClass("valid", requirements.specialCharacter);
                            break;
                        case 3:
                            $(this).toggleClass("valid", requirements.length);
                            break;
                    }
                });
            };

            $("#new_password").on("input", updateRequirements);
            $("#old_password").on("input", updateRequirements);
            $("#confirm_password").on("input", updateRequirements);

            // Show/hide passwords when checkbox is checked/unchecked
            $("#show_passwords").on("change", function () {
                const type = this.checked ? "text" : "password";
                $("#old_password, #new_password, #confirm_password").attr("type", type);
            });

            var swalMessage = "<?php echo isset($swalMessage) ? $swalMessage : ''; ?>";
            if (swalMessage) {
                var parts = swalMessage.split('|');
                var type = parts[0];  // "success" or "error"
                var message = parts[1];  // The actual message

                Swal.fire({
                    title: (type === 'success') ? 'Success!' : 'Error!',
                    text: message,
                    icon: type,
                    confirmButtonText: 'OK'
                }).then(() => {
                    if (type === 'success') {
                        window.location.href = 'dashboardhome.php'; // Redirect to the dashboard or appropriate page
                    }
                });
            }
        });
    </script>
</head>

<body>
    <div class="form-container">
        <h2>Change Password</h2>
        <form method="POST">
            <div class="mb-3">
                <input type="checkbox" id="show_passwords" class="form-check-input">
                <label for="show_passwords" class="form-check-label">Show Passwords</label>
            </div>
            <div class="mb-3">
                <label for="old_password" class="form-label">Old Password:</label>
                <input type="password" class="form-control" name="old_password" id="old_password" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password:</label>
                <input type="password" class="form-control" name="new_password" id="new_password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm New Password:</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
            </div>
            <ul class="requirement" style="display: none;"> <!-- Initially hidden -->
                <li>1 capital letter</li>
                <li>1 number</li>
                <li>1 special character</li>
                <li>Minimum 8 characters long</li>
            </ul>
            <span class="password-requirements"><?php echo $password_requirements_message; ?></span>
            <span class="password-match"><?php echo $password_match_message; ?></span>
            <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
    </div>
</body>

</html>