<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include PHPMailer classes
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Use PHPMailer namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include your database connection
include "config/connection.php";

// Example: including a sidebar for admin if needed
include "sidebaradmin.php";

// Initialize PHPMailer
$mail = new PHPMailer(true);

function getSuffix($suffix)
{
    $valid_suffixes = ['Jr', 'Sr', 'III', 'IV', 'V'];
    return in_array($suffix, $valid_suffixes) ? $suffix : '';
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $account_number = $_POST['account_number'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $middlename = $_POST['middlename'];
    $suffix = getSuffix($_POST['suffix']); // Handle suffix
    $birthday = $_POST['birthday'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $confirm_email = $_POST['confirm_email']; // New field for confirm email
    $contactnumber = $_POST['contactnumber'];

    $contactnumber = preg_replace('/\D/', '', $contactnumber); // Remove all non-numeric characters

    $province_id = $_POST['province_id'];
    $municipality_id = $_POST['municipality_id'];
    $barangay_id = $_POST['barangay_id'];
    $address = $_POST['address'];
    $balance = 0;
    $role = "User";

    // Generate a random password
    $random_password = bin2hex(random_bytes(4)); // Generates an 8-character password
    $hashed_password = md5($random_password); // Hash the password using MD5

    $stmt = $conn->prepare("INSERT INTO users1 (account_number, firstname, lastname, middlename, suffix, birthday, age, gender, email, contactnumber, province_id, municipality_id, barangay_id, address, password, balance, role) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");


    // Adjust the type definition string to match the placeholders
    $stmt->bind_param("sssssssssiiiissds", $account_number, $firstname, $lastname, $middlename, $suffix, $birthday, $age, $gender, $email, $contactnumber, $province_id, $municipality_id, $barangay_id, $address, $hashed_password, $balance, $role);
    if ($stmt->execute()) {
        // Send email with PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                      // Specify SMTP server
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'jemusu96@gmail.com';              // SMTP username
            $mail->Password = 'aybfptvlrktcrfjx';               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            // Recipients
            $mail->setFrom('jemusu96@gmail.com', 'Jemusu');
            $mail->addAddress($email, $firstname . ' ' . $lastname); // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Registration Successful';
            $mail->Body = "
                <p>Dear $firstname,</p>
                <p>We are pleased to inform you that your account has been successfully created.</p>
                <p>Your login credentials are as follows:</p>
                <p><strong>Account Number:</strong> $account_number<br>
                <strong>Password:</strong> $random_password</p>
                <p>For your security, we recommend changing your password immediately after logging in.</p>
                <p>If you have any questions or need assistance, feel free to contact our support team.</p>
                <p>Thank you for choosing RAMSTAR.</p>
                <p>Best regards,<br>RAMSTAR</p>
            ";

            $mail->send();
            $swalMessage = "success|Registration Successful! Your Login credentials have been sent to $email.";
        } catch (Exception $e) {
            // Error message for failed email sending
            $swalMessage = "error|Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // Error message for failed registration
        $swalMessage = "error|Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Show alert with message

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/register.css">
    <title>Registration Form</title>

    <script>
        $(document).ready(function () {
            // Check if the PHP variable has a message
            <?php if (!empty($swalMessage)): ?>
                var swalMessage = "<?php echo $swalMessage; ?>";
                var messageParts = swalMessage.split('|');
                var status = messageParts[0];
                var message = messageParts[1];

                // Call SweetAlert with the message
                Swal.fire({
                    icon: status,
                    title: status === 'success' ? 'Success' : 'Error',
                    text: message,
                    confirmButtonText: 'OK'
                });
            <?php endif; ?>
        });

    </script>

    <script>

        $(document).ready(function () {
            $('#contactnumber').on('input', function () {
                // Remove any non-digit characters
                let input = $(this).val().replace(/\D/g, '');

                // Check if the input exceeds 10 digits
                if (input.length > 10) {
                    input = input.slice(0, 10); // Limit to 10 digits
                }

                // Update the input value with the +63 prefix

            });
        });

        $(document).ready(function () {
            // Cascading dropdowns for province and municipalities
            $('#province').change(function () {
                var provinceId = $(this).val();
                $.ajax({
                    url: 'fetch_municipalities.php',
                    type: 'GET',
                    data: { province_id: provinceId },
                    success: function (response) {
                        var municipalities = $('#municipality');
                        municipalities.empty();
                        municipalities.append('<option value="">Select Municipality</option>');
                        municipalities.append(response);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $('#municipality').change(function () {
                var municipalityId = $(this).val();
                $.ajax({
                    url: 'fetch_barangays.php',
                    type: 'POST',
                    data: { municipality_id: municipalityId },
                    dataType: 'json',
                    success: function (response) {
                        var barangays = $('#barangay');
                        barangays.empty();
                        barangays.append('<option value="">Select Barangay</option>');
                        $.each(response, function (index, barangay) {
                            barangays.append('<option value="' + barangay.id + '">' + barangay.barangay + '</option>');
                        });
                    }
                });
            });

            // Confirmation and RFID handling
            let confirmationShown = false;

            $('.btn-primary').click(function (event) {
                event.preventDefault(); // Prevent the default form submission

                if (!confirmationShown) {
                    confirmationShown = true;

                    Swal.fire({
                        title: 'Confirm Registration',
                        text: "Are you sure you want to register?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#cc0000',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, register!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Waiting for RFID',
                                text: 'Please scan your RFID tag.',
                                icon: 'info',
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });

                            $('#account_number').removeAttr('readonly').focus();
                        } else {
                            confirmationShown = false;
                        }
                    });
                }
            });

            $('#account_number').on('input', function () {
                var rfidValue = $(this).val();

                if (rfidValue.length === 10) { // Adjust the length if needed
                    Swal.fire({
                        title: 'RFID Scanned!',
                        text: 'Your RFID tag has been successfully scanned. Proceeding with registration...',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });

                    setTimeout(function () {
                        $('form').submit();
                    }, 3000);
                }
            });

            // Birthday and age validation
            function calculateAge(birthday) {
                const today = new Date();
                const birthDate = new Date(birthday);
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                return age;
            }

            const maxDate = new Date(new Date().setFullYear(new Date().getFullYear() - 7)).toISOString().split('T')[0];
            $('#birthday').attr('max', maxDate);

            $('#birthday').change(function () {
                const birthday = $(this).val();
                const age = calculateAge(birthday);

                if (age < 7) {
                    alert('Age cannot be less than 7 years.');
                    $(this).val('');
                    $('#age').val('');
                } else {
                    $('#age').val(age);
                }
            });

            $(document).ready(function () {
                // Existing code...

                // Email confirmation validation
                $('#email, #confirm_email').on('input', function () {
                    var email = $('#email').val();
                    var confirmEmail = $('#confirm_email').val();

                    if (email === confirmEmail) {
                        $('#email-error').hide(); // Hide the error message
                    } else {
                        $('#email-error').show(); // Show the error message
                    }
                });

            });

        });

    </script>
</head>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Registration Form</title>
    <style>
        body {
            background-color: #f7f7f7;
            font-family: Arial, sans-serif;
        }

        .form-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 40px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            background-color: blue;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .form-label {
            color: blue;
            font-weight: bold;
        }

        .form-control {
            border: 2px solid #ffcc00;
            padding: 12px;
            background-color: #fff4cc;
            width: 100%;
        }

        .form-control:focus {
            border-color: #ff9900;
            box-shadow: 0 0 6px rgba(255, 153, 0, 0.3);
        }

        .btn-primary {
            background-color: #cc0000;
            border-color: #cc0000;
            color: white;
            font-weight: bold;
            padding: 12px;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #ffcc00;
            border-color: #ffcc00;
            color: blue;
        }

        .mb-3 {
            margin-bottom: 20px !important;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Registration Form</h2>
        <form method="POST">
            <div class="row">
                <!-- First Name -->
                <div class="col-md-6 mb-3">
                    <label for="firstname" class="form-label">First Name:</label>
                    <input type="text" class="form-control" name="firstname" id="firstname" required>
                </div>

                <!-- Last Name -->
                <div class="col-md-6 mb-3">
                    <label for="lastname" class="form-label">Last Name:</label>
                    <input type="text" class="form-control" name="lastname" id="lastname" required>
                </div>

                <!-- Middle Name -->
                <div class="col-md-6 mb-3">
                    <label for="middlename" class="form-label">Middle Name:</label>
                    <input type="text" class="form-control" name="middlename" id="middlename" required>
                </div>

                <!-- Suffix -->
                <div class="col-md-6 mb-3">
                    <label for="suffix" class="form-label">Suffix:</label>
                    <select name="suffix" class="form-control" id="suffix">
                        <option value="">None</option>
                        <option value="Jr">Jr</option>
                        <option value="Sr">Sr</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                        <option value="V">V</option>
                    </select>
                </div>

                <!-- Birthday -->
                <div class="col-md-6 mb-3">
                    <label for="birthday" class="form-label">Birthday:</label>
                    <input type="date" class="form-control" name="birthday" id="birthday" required
                        onchange="calculateAge()">
                </div>

                <!-- Age (Display Only) -->
                <div class="col-md-6 mb-3">
                    <label for="age" class="form-label">Age:</label>
                    <input type="text" class="form-control" name="age" id="age" readonly required>
                </div>

                <!-- Gender -->
                <div class="col-md-6 mb-3">
                    <label for="gender" class="form-label">Gender:</label>
                    <select name="gender" class="form-control" id="gender" required>
                        <option value="Other">Other</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <!-- Email -->
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>

                <!-- Confirm Email -->
                <div class="col-md-6 mb-3">
                    <label for="confirm_email" class="form-label">Confirm Email:</label>
                    <input type="email" class="form-control" name="confirm_email" id="confirm_email" required>
                    <div id="email-error" class="text-danger" style="display: none;">Emails do not match!</div>
                </div>

                <!-- Contact Number -->
                <div class="col-md-6 mb-3">
                    <label for="contactnumber" class="form-label">Contact Number:</label>
                    <input type="text" class="form-control" name="contactnumber" id="contactnumber" required
                        maxlength="12" placeholder="XXXXXXXXXX">
                </div>

                <!-- Province -->
                <div class="col-md-6 mb-3">
                    <label for="province_id" class="form-label">Province:</label>
                    <select name="province_id" class="form-control" id="province" required>
                        <option value="">Select Province</option>
                        <?php
                        $result = $conn->query("SELECT province_id, provincestate FROM provincestate");
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['province_id'] . '">' . htmlspecialchars($row['provincestate']) . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <!-- Municipality -->
                <div class="col-md-6 mb-3">
                    <label for="municipality_id" class="form-label">Municipality:</label>
                    <select name="municipality_id" class="form-control" id="municipality" required>
                        <option value="">Select Municipality</option>
                    </select>
                </div>

                <!-- Barangay -->
                <div class="col-md-6 mb-3">
                    <label for="barangay_id" class="form-label">Barangay:</label>
                    <select name="barangay_id" class="form-control" id="barangay" required>
                        <option value="">Select Barangay</option>
                    </select>
                </div>

                <!-- Address -->
                <div class="col-md-6 mb-3">
                    <label for="address" class="form-label">Address:</label>
                    <input type="text" class="form-control" name="address" id="address" required>
                </div>

                <!-- Account Number -->
                <div class="col-md-6 mb-3">
                    <label for="account_number" class="form-label">Account Number (RFID):</label>
                    <input type="text" class="form-control" name="account_number" id="account_number" readonly required>
                </div>

                <!-- Submit Button -->
                <div class="col-md-12 mb-3">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function calculateAge() {
            const birthdayInput = document.getElementById("birthday");
            const ageInput = document.getElementById("age");

            const birthday = new Date(birthdayInput.value);
            const today = new Date();

            if (birthday) {
                let age = today.getFullYear() - birthday.getFullYear();
                const monthDifference = today.getMonth() - birthday.getMonth();
                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthday.getDate())) {
                    age--;
                }
                ageInput.value = age; // Set the calculated age
            } else {
                ageInput.value = ""; // Clear age if birthday is not selected
            }
        }
    </script>
</body>

</html>