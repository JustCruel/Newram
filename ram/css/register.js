$(document).ready(function () {
    var swalMessage = "<?php echo $swalMessage; ?>";
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
                window.location.href = 'register.php'; // Redirect to login page on success
            }
        });
    }
});

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
