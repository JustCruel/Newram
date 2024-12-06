<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'sidebar.php';

$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery added here -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/style.css">

    <title>Registration Form</title>
    <style>
        .register {
            background-color: #cc0000;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        h2 {
            color: black;
        }

        .register:hover {
            background-color: #b30000;
        }

        /* Styling for the contact number input group */
        .form-group {
            position: relative;
        }

        /* Country code styling */
        .country-code {
            background-color: #f8f9fa;
            /* Light background */
            border-right: 1px solid #ced4da;
            /* Border to separate from input */
            display: flex;
            align-items: center;
            /* Center vertically */
            padding: 0.5rem;
            /* Padding around the text */
            font-weight: bold;
            /* Bold text for emphasis */
        }

        /* Contact number input field */
        #phone {
            padding-left: 0.5rem;
            /* Padding to align text with country code */
        }

        /* Adjust width to ensure country code and input look good together */
        .form-group .form-control {
            flex: 1;
            /* Allow the input to take up remaining space */
            min-width: 0;
            /* Prevent overflow */
        }
    </style>
    <script>
        $(document).ready(function () {
            let confirmationShown = false; // To track confirmation dialog
            let rfidScanned = false; // To track if RFID has been scanned

            $('#phone').on('input', function () {
                var contactValue = $(this).val();

                // Allow only digits and limit to 11 characters
                contactValue = contactValue.replace(/[^0-9]/g, ''); // Remove non-numeric characters
                if (contactValue.length > 11) {
                    contactValue = contactValue.substring(0, 11); // Limit to 11 digits
                }
                $(this).val(contactValue); // Update the input value

                // Send AJAX request if the input has exactly 11 characters
                if (contactValue.length === 11) {
                    $.ajax({
                        type: "POST",
                        url: "check_contact.php",
                        data: { contactnumber: contactValue },
                        dataType: "json",
                        success: function (response) {
                            if (response.exists) {
                                $('#phone').addClass('is-invalid'); // Add invalid class to input
                                // Set error message directly in the existing div
                                $('#contactError').text("This contact number is already registered.").show();
                            } else {
                                $('#phone').removeClass('is-invalid'); // Remove invalid class
                                $('#contactError').hide(); // Hide error message if it exists
                            }
                        },
                        error: function () {
                            console.error("Error checking contact number.");
                        }
                    });
                } else {
                    $('#phone').removeClass('is-invalid');
                    $('#contactError').hide(); // Hide error message if the input is less than 11 characters
                }
            });


            $('#email').on('input', function () {
                var email = $(this).val();

                // Check if email is not empty
                if (email) {
                    $.ajax({
                        url: 'check_email.php', // Path to your PHP script
                        type: 'POST',
                        data: { email: email },
                        dataType: 'json',
                        success: function (response) {
                            if (response.exists) {
                                // Email already exists
                                $('#email').addClass('is-invalid');
                                $('#emailFeedback').remove();
                                $('#email').after('<div id="emailFeedback" class="invalid-feedback">This email is already registered.</div>');
                            } else {
                                // Email does not exist
                                $('#email').removeClass('is-invalid');
                                $('#emailFeedback').remove();
                            }
                        },
                        error: function () {
                            console.error('Error checking email.');
                        }
                    });
                } else {
                    // Reset feedback if email is empty
                    $('#email').removeClass('is-invalid');
                    $('#emailFeedback').remove();
                }
            });

            $('.register').click(function (event) {
                event.preventDefault(); // Prevent the default form submission

                if (!confirmationShown) {
                    confirmationShown = true;

                    Swal.fire({
                        title: 'Confirm Registration?',
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
                            confirmationShown = false; // Reset if cancelled
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
                        confirmButtonText: 'OK',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Only submit the form after the user clicks 'OK'
                            $('form').submit();
                        }
                    });
                }
            });

            // Birthday and age validation
            function calculateAge(birthday) {
                let today = new Date();
                let birthDate = new Date(birthday);
                let age = today.getFullYear() - birthDate.getFullYear();
                let monthDifference = today.getMonth() - birthDate.getMonth();
                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                return age;
            }

            $('#birthday').change(function () {
                let birthday = $(this).val();
                if (birthday) {
                    let age = calculateAge(birthday);
                    $('#age').val(age);
                }
            });

            // Load provinces on page load
            $.ajax({
                url: 'https://psgc.gitlab.io/api/provinces', // API URL for provinces
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Populate the province dropdown
                    $.each(data, function (index, province) {
                        $('#province').append($('<option>', {
                            value: province.code,
                            text: province.name
                        }));
                    });
                },
                error: function () {
                    console.error('Error fetching provinces');
                }
            });

            // When a province is selected, fetch municipalities
            $('#province').change(function () {
                const provinceCode = $(this).val();
                $('#municipality').empty().append('<option value="">-- Select Municipality --</option>');
                $('#barangay').empty().append('<option value="">-- Select Barangay --</option>');

                if (provinceCode) {
                    $.ajax({
                        url: 'https://psgc.gitlab.io/api/municipalities', // API URL for municipalities
                        method: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            // Filter municipalities by province code
                            const municipalities = data.filter(municipality => municipality.provinceCode === provinceCode);

                            if (municipalities.length > 0) {
                                $.each(municipalities, function (index, municipality) {
                                    $('#municipality').append($('<option>', {
                                        value: municipality.code,
                                        text: municipality.name
                                    }));
                                });
                            } else {
                                console.warn('No municipalities found for this province.');
                            }
                        },
                        error: function () {
                            console.error('Error fetching municipalities');
                        }
                    });
                }
            });

            // When a municipality is selected, fetch barangays
            $('#municipality').change(function () {
                const municipalityCode = $(this).val();
                $('#barangay').empty().append('<option value="">-- Select Barangay --</option>');

                if (municipalityCode) {
                    // Adjusted barangay API call
                    $.ajax({
                        url: `https://psgc.gitlab.io/api/barangays`, // Ensure this endpoint is correct
                        method: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            // Filter barangays by municipality code
                            const barangays = data.filter(barangay => barangay.municipalityCode === municipalityCode);

                            if (barangays.length > 0) {
                                $.each(barangays, function (index, barangay) {
                                    $('#barangay').append($('<option>', {
                                        value: barangay.code,
                                        text: barangay.name
                                    }));
                                });
                            } else {
                                console.warn('No barangays found for this municipality.');
                            }
                        },
                        error: function () {
                            console.error('Error fetching barangays');
                        }
                    });
                }
            });
        });

    </script>
</head>

<body>
    <div class="container mt-5">
        <h2>Registration Form</h2>
        <form method="POST" action="confirm_register.php" id="registrationForm" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="account_number" class="form-label">Account Number</label>
                    <input type="text" class="form-control" id="account_number" name="account_number" required>
                </div>
                <div class="col-md-6">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" required>
                </div>
                <div class="col-md-6">
                    <label for="middlename" class="form-label">Middle Name</label>
                    <input type="text" class="form-control" id="middlename" name="middlename">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="suffix" class="form-label">Suffix</label>
                    <select class="form-select" id="suffix" name="suffix">
                        <option value="">-- Select Suffix --</option>
                        <option value="Jr">Jr</option>
                        <option value="Sr">Sr</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                        <option value="V">V</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="birthday" class="form-label">Birthday</label>
                    <input type="date" class="form-control" id="birthday" name="birthday" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" id="age" name="age" readonly>
                </div>
                <div class="col-md-6">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="">-- Select Gender --</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="col-md-6">
                    <label for="province" class="form-label">Province</label>
                    <select class="form-select" id="province" name="province" required>
                        <option value="">-- Select Province --</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="municipality" class="form-label">Municipality</label>
                    <select class="form-select" id="municipality" name="municipality" required>
                        <option value="">-- Select Municipality --</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="barangay" class="form-label">Barangay</label>
                    <select class="form-select" id="barangay" name="barangay" required>
                        <option value="">-- Select Barangay --</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="id_type" class="form-label">ID Type</label>
                    <select class="form-select" id="id_type" name="id_type" required>
                        <option value="">-- Select ID Type --</option>
                        <option value="National ID">National ID</option>
                        <option value="Passport">Passport</option>
                        <option value="Driver's License">Driver's License</option>
                        <option value="PSA Original">PSA Original</option>
                        <option value="Postal ID">Postal ID</option>
                        <option value="PhilHealth">PhilHealth</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="id_file" class="form-label">Upload ID</label>
                    <input type="file" class="form-control" id="id_file" name="id_file" accept="image/*" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div id="emailFeedback" class="invalid-feedback"></div>
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label">Contact Number</label>
                    <div class="form-group d-flex">
                        <span class="border-end country-code px-2">+63</span>
                        <input type="text" class="form-control" id="phone" name="contactnumber" placeholder="" required
                            pattern="\d{11}" maxlength="11" />

                    </div>
                    <div id="contactError" class="invalid-feedback" style="display: none;"></div>
                    <!-- Initially hidden -->
                </div>
            </div>



            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</body>


</html>