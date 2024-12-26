<?php
// Include PHPMailer classes
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Use PHPMailer namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include your database connection
include "config/connection.php";

// Initialize PHPMailer
$mail = new PHPMailer(true);

// Function to generate OTP
function generateOTP($length = 6) {
    return substr(str_shuffle("0123456789"), 0, $length);  // Generate a random 6-digit OTP
}

// Initialize otp_sent and password_updated variables to avoid undefined warnings
$otp_sent = false;
$password_updated = false;
$error_message = '';

// Handle Forgot Password form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'forgot_password' && isset($_POST['email'])) {
    // Collect form data
    $email = $_POST['email'];
    $otp = generateOTP();  // Generate OTP

    // Check if email exists in the database
    $stmt = $conn->prepare("SELECT * FROM useracc WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Send OTP via email
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ramstarzaragoza@gmail.com'; // Your email
            $mail->Password = 'hwotyendfdsazoar'; // Your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('ramstarzaragoza@gmail.com', 'Ramstar Bus Transportation');
            $mail->addAddress($email, $user['firstname'] . ' ' . $user['lastname']);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = "
                <p>Dear {$user['firstname']},</p>
                <p>Your OTP for password reset is <strong>$otp</strong></p>
                <p>This OTP will expire in 15 minutes. Please use it to reset your password.</p>
                <p>Best regards,<br>RAMSTAR</p>
            ";

            $mail->send();

            // Store OTP and expiration time in the database for validation
            $otp_expiry = date('Y-m-d H:i:s', strtotime('+15 minutes')); // OTP expires in 15 minutes
            $stmt = $conn->prepare("UPDATE useracc SET otp = ?, otp_expiry = ? WHERE email = ?");
            $stmt->bind_param("sss", $otp, $otp_expiry, $email);
            $stmt->execute();

            $otp_sent = true;  // Flag to indicate OTP was sent successfully
        } catch (Exception $e) {
            $error_message = "Error sending email: {$mail->ErrorInfo}";
        }
    } else {
        $error_message = "No account found with this email.";
    }

    $stmt->close();
}

// Handle OTP verification and password reset
// Handle OTP verification and password reset
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'verify_otp' && isset($_POST['email'])) {
    // Collect form data
    $email = $_POST['email'];
    $entered_otp = $_POST['otp'];
    $new_password = $_POST['new_password'];

    // Check if the OTP is valid and not expired
    $stmt = $conn->prepare("SELECT otp, otp_expiry FROM useracc WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

      // Execute query to fetch user data by email
$stmt = $conn->prepare("SELECT * FROM useracc WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc(); // Get user data

// Check if 'firstname' and 'lastname' exist and are not empty
if ($user) {
    $firstname = isset($user['firstname']) && !empty($user['firstname']) ? $user['firstname'] : 'User'; // Default to 'User' if not found
    $lastname = isset($user['lastname']) && !empty($user['lastname']) ? $user['lastname'] : '';  // Empty last name if not found
    $fullname = $firstname . ' ' . $lastname;
} else {
    $fullname = 'User'; // If no user found
}
    

    if ($user) {
        // Check if OTP matches and is not expired
        if ($entered_otp === $user['otp'] && strtotime($user['otp_expiry']) > time()) {
            // Update password with MD5 hash
            $hashed_password = md5($new_password); // MD5 hash the new password
            $stmt = $conn->prepare("UPDATE useracc SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $hashed_password, $email);
            if ($stmt->execute()) {
                $password_updated = true;  // Password updated successfully
                
                // Send confirmation email about password change
               // Send confirmation email about password change
try {
    // Server settings for sending the password change success email
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'ramstarzaragoza@gmail.com';
    $mail->Password = 'hwotyendfdsazoar';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
   
    $mail->setFrom('ramstarzaragoza@gmail.com', 'Ramstar Bus Transportation');
    $mail->addAddress($email,$fullname);


    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Password Reset Successful';

    // Check if firstname and lastname exist in the $user array
    $firstname = isset($user['firstname']) ? $user['firstname'] : 'User';
    $lastname = isset($user['lastname']) ? $user['lastname'] : '';

    $mail->Body = "
        <p>Dear {$firstname} {$lastname},</p>
        <p>Your password has been successfully updated.</p>
        <p>If you did not request this change, please contact support immediately.</p>
        <p>Best regards,<br>RAMSTAR</p>
    ";

    $mail->send();
} catch (Exception $e) {
    $error_message = "Error sending confirmation email: {$mail->ErrorInfo}";
}

            } else {
                $error_message = "Error updating password.";
            }
        } else {
            $error_message = "Invalid or expired OTP.";
        }
    } else {
        $error_message = "No account found with this email.";
    }

    $stmt->close();
}


$conn->close();
?>

<!-- Include SweetAlert CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.5/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.5/dist/sweetalert2.min.js"></script>

<!-- Custom Styling -->
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f7fc;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .form-container {
        background-color: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }
    .form-container h2 {
        margin-bottom: 20px;
        text-align: center;
    }
    label {
        font-size: 14px;
        margin-bottom: 6px;
        display: block;
    }
    input[type="email"],
    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    button {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        border: none;
        color: white;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
    }
    button:hover {
        background-color: #45a049;
    }
</style>

<!-- Forgot Password Form -->
<?php if (!$otp_sent) { ?> <!-- Only show this form if OTP has not been sent -->
<div class="form-container">
    <h2>Forgot Password</h2>
    <form method="POST">
        <input type="hidden" name="action" value="forgot_password">
        <label for="email">Email Address:</label>
        <input type="email" name="email" required>
        <button type="submit">Send OTP</button>
    </form>
</div>
<?php } ?>

<!-- OTP Verification Form (after OTP sent) -->
<?php if ($otp_sent) { ?>
<div class="form-container">
    <h2>Verify OTP</h2>
    <form method="POST">
        <input type="hidden" name="action" value="verify_otp">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>"> <!-- Include email for verification -->
        <label for="otp">Enter OTP:</label>
        <input type="text" name="otp" required>
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>
        <button type="submit">Reset Password</button>
    </form>
</div>
<?php } ?>

<!-- JavaScript to Trigger SweetAlert -->
<script type="text/javascript">
    <?php if ($otp_sent) { ?>
        Swal.fire({
            icon: 'success',
            title: 'OTP Sent!',
            text: 'An OTP has been sent to your email. Please check your inbox.',
            confirmButtonText: 'OK'
        });
    <?php } elseif ($password_updated) { ?>
        Swal.fire({
            icon: 'success',
            title: 'Password Reset Successful!',
            text: 'Your password has been updated successfully.',
            confirmButtonText: 'OK'
        });
    <?php } elseif ($error_message) { ?>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '<?php echo $error_message; ?>',
            confirmButtonText: 'OK'
        });
    <?php } ?>
</script>
