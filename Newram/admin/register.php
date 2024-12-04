<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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

        .register:hover {
            background-color: #b30000;
        }
    </style>
    <script>
        $(document).ready(function () {
            let confirmationShown = false; // To track confirmation dialog
            let rfidScanned = false; // To track if RFID has been scanned

            $('.register').click(function (event) {
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
        <form method="POST" action="confirm_register.php" id="registrationForm">

            <div class="mb-3">
                <label for="account_number" class="form-label">Account Number</label>
                <input type="text" class="form-control" id="account_number" name="account_number" required>
            </div>
            <div class="mb-3">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
            <div class="mb-3">
                <label for="middlename" class="form-label">Middle Name</label>
                <input type="text" class="form-control" id="middlename" name="middlename">
            </div>
            <div class="mb-3">
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
            <div class="mb-3">
                <label for="birthday" class="form-label">Birthday</label>
                <input type="date" class="form-control" id="birthday" name="birthday" required>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age" readonly>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="">-- Select Gender --</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="confirm_email" class="form-label">Confirm Email</label>
                <input type="email" class="form-control" id="confirm_email" name="confirm_email" required>
            </div>
            <div class="mb-3">
                <label for="contactnumber" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="contactnumber" name="contactnumber" required>
            </div>
            <div class="mb-3">
                <label for="province" class="form-label">Province</label>
                <select class="form-select" id="province" name="province_id" required>
                    <option value="">-- Select Province --</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="municipality" class="form-label">Municipality</label>
                <select class="form-select" id="municipality" name="municipality_id" required>
                    <option value="">-- Select Municipality --</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="barangay" class="form-label">Barangay</label>
                <select class="form-select" id="barangay" name="barangay_id" required>
                    <option value="">-- Select Barangay --</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" required></textarea>
            </div>
            <button type="submit" class="btn register">Register</button>
        </form>
    </div>
</body>

</html>