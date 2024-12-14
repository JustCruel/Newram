<?php
// Include PHPMailer classes
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

// Use PHPMailer namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include your database connection
include "../config/connection.php";

// Initialize PHPMailer
$mail = new PHPMailer(true);

// Function to validate suffix
function getSuffix($suffix)
{
    $valid_suffixes = ['Jr', 'Sr', 'III', 'IV', 'V'];
    return in_array($suffix, $valid_suffixes) ? $suffix : '';
}

// Initialize flags
$registration_successful = false;
$error_message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $account_number = $_POST['account_number'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $middlename = $_POST['middlename'];
    $suffix = getSuffix($_POST['suffix']);
    $birthday = $_POST['birthday'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $contactnumber = preg_replace('/\D/', '', $_POST['contactnumber']);
    $province_id = $_POST['province'];
    $municipality_id = $_POST['municipality'];
    $barangay_id = $_POST['barangay'];
    $address = $_POST['address'];


    // Allow certain file formats


    // Only proceed if no errors encountered
    if (empty($error_message)) {
        // Generate a random password
        $random_password = bin2hex(random_bytes(4));
        $hashed_password = md5($random_password);
        $balance = 0.00; // Default balance
        $role = 'User'; // Default role
        $points = 0.00; // Default points

        // Send email with PHPMailer
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'jemusu96@gmail.com'; // Your email
            $mail->Password = 'aybfptvlrktcrfjx'; // Your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('jemusu96@gmail.com', 'Jemusu');
            $mail->addAddress($email, $firstname . ' ' . $lastname);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Registration Successful';
            $mail->Body = "
                <p>Dear $firstname,</p>
                <p>Your account has been successfully created.</p>
                <p><strong>Account Number:</strong> $account_number<br>
                <strong>Password:</strong> $random_password</p>
                <p>Change your password after logging in for security.</p>
                <p>Best regards,<br>RAMSTAR</p>
            ";

            $mail->send();

            // Only insert into database if email was successfully sent
            $stmt = $conn->prepare("INSERT INTO useracc (account_number, firstname, lastname, middlename, suffix, birthday, age, gender, email, contactnumber, province, municipality, barangay, address, password, balance, role, points) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            // Ensure you have 20 variables here
            $stmt->bind_param(
                "sssssssssiiiissdsd",
                $account_number,
                $firstname,
                $lastname,
                $middlename,
                $suffix,
                $birthday,
                $age,
                $gender,
                $email,
                $contactnumber,
                $province_id, // Correctly use the variable from POST
                $municipality_id,
                $barangay_id,
                $address,
                $hashed_password,
                $balance,
                $role,
                $points
            );

            if ($stmt->execute()) {
                $registration_successful = true; // Set flag to true
            } else {
                $error_message = "Error: " . $stmt->error;
            }

            $stmt->close();
        } catch (Exception $e) {
            $error_message = "Error sending email: {$mail->ErrorInfo}";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php if ($registration_successful): ?>
        <script>
            Swal.fire({
                title: 'Registration Successful!',
                text: 'Your login credentials have been sent to <?php echo htmlspecialchars($email); ?>.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '/Newram/superadmin/superadmin.php';
            });
        </script>
    <?php elseif ($error_message): ?>
        <script>
            Swal.fire({
                title: 'Error!',
                text: '<?php echo htmlspecialchars($error_message); ?>',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    <?php endif; ?>
</body>

</html>