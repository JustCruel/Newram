<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Fare Management System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.9/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 700px;
            margin-top: 50px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-custom {
            background-color: #4CAF50;
            color: white;
            border: none;
            font-weight: bold;
        }

        .btn-custom:hover {
            background-color: #45a049;
        }

        .btn-danger {
            background-color: #d9534f;
        }

        .btn-danger:hover {
            background-color: #c9302c;
        }

        .receipt-info {
            margin-top: 20px;
            padding: 15px;
            background-color: #f7f7f7;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center mb-4">Bus Fare Management System</h1>

        <!-- RFID Scan Input -->
        <div class="mb-3">
            <label for="rfid" class="form-label">Enter RFID Card ID</label>
            <input type="text" id="rfid" class="form-control" placeholder="Scan RFID or Enter RFID ID"
                oninput="checkRFID()">
        </div>

        <!-- Start Point Selection -->
        <div class="mb-3">
            <label for="start-stop" class="form-label">Select Starting Point</label>
            <select id="start-stop" class="form-select">
                <option value="Zaragoza">Zaragoza</option>
                <option value="Santa Rosa">Santa Rosa</option>
                <option value="Cabanatuan Terminal">Cabanatuan Terminal</option>
            </select>
        </div>

        <!-- End Point Selection -->
        <div class="mb-3">
            <label for="end-stop" class="form-label">Select Destination</label>
            <select id="end-stop" class="form-select">
                <option value="Zaragoza">Zaragoza</option>
                <option value="Santa Rosa">Santa Rosa</option>
                <option value="Cabanatuan Terminal">Cabanatuan Terminal</option>
            </select>
        </div>

        <!-- Action Buttons -->
        <button class="btn btn-custom w-100" id="tap-in-btn" style="display: none;" onclick="processScan('tap_in')">Tap
            In</button>
        <button class="btn btn-danger w-100 mt-2" id="tap-out-btn" style="display: none;"
            onclick="processScan('tap_out')">Tap Out</button>

        <!-- Payment Information -->
        <div id="payment-info" class="mt-3"></div>

        <!-- Receipt -->
        <div id="receipt-info" class="receipt-info" style="display: none;"></div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.9/dist/sweetalert2.min.js"></script>
    <script>
        // Function to check the current status of the user based on RFID ID
        window.onload = function () {
            document.getElementById('rfid').focus();
        };

        function checkRFID() {
            const rfidId = document.getElementById('rfid').value;

            if (rfidId.length >= 5) {
                fetch('process_rfid.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `rfid_id=${rfidId}&action=check_status`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            document.getElementById('payment-info').innerHTML = data.message;

                            if (data.active_trip) {
                                // Show Tap Out button and pre-fill start stop from active trip
                                document.getElementById('tap-out-btn').style.display = 'block';
                                document.getElementById('tap-in-btn').style.display = 'none';
                                disableStartStop(); // Disable start stop on tap out
                                enableEndStop();  // Enable end stop

                                // Pre-fill start stop in dropdown for tap-out
                                document.getElementById('start-stop').value = data.start_stop;
                            } else {
                                // Show Tap In button
                                document.getElementById('tap-in-btn').style.display = 'block';
                                document.getElementById('tap-out-btn').style.display = 'none';
                                disableEndStop(); // Disable end stop on tap in
                                enableStartStop(); // Enable start stop
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);  // Handle errors
                        showErrorAlert('An error occurred while processing RFID.');
                    });
            }
        }

        // Disable the Start Stop dropdown
        function disableStartStop() {
            document.getElementById('start-stop').disabled = true;
        }

        // Disable the End Stop dropdown
        function disableEndStop() {
            document.getElementById('end-stop').disabled = true;
        }

        // Enable the Start Stop dropdown
        function enableStartStop() {
            document.getElementById('start-stop').disabled = false;
        }

        // Enable the End Stop dropdown
        function enableEndStop() {
            document.getElementById('end-stop').disabled = false;
        }

        // Process the scan action (Tap In or Tap Out)
        function processScan(action) {
            const rfidId = document.getElementById('rfid').value;
            const startStop = document.getElementById('start-stop').value;
            const endStop = document.getElementById('end-stop').value;

            fetch('process_rfid.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `rfid_id=${rfidId}&action=${action}&start_stop=${startStop}&end_stop=${endStop}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showSuccessAlert(data.message);

                        if (data.fare) {
                            document.getElementById('payment-info').innerHTML += `<br>Fare: ${data.fare}`;

                            // Generate the receipt
                            generateReceipt(rfidId, data.new_balance, data.start_stop, data.end_stop, data.fare, data.transaction_time);
                        }
                    } else {
                        showErrorAlert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorAlert('An error occurred while processing your request.');
                });
        }

        // Generate the receipt
        function generateReceipt(rfidId, newBalance, startStop, endStop, fare, transactionTime) {
            const receipt = `
                <strong>Receipt</strong><br>
                RFID ID: ${rfidId}<br>
                Start Stop: ${startStop}<br>
                End Stop: ${endStop}<br>
                Fare: ${fare}<br>
                New Balance: ${newBalance} pesos<br>
                Transaction Time: ${transactionTime}
            `;
            document.getElementById('receipt-info').innerHTML = receipt;
            document.getElementById('receipt-info').style.display = 'block';
        }

        // Show success notification with SweetAlert
        function showSuccessAlert(message) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: message,
                showConfirmButton: true,
            }).then(() => {
                // After clicking OK, reload the page and focus on RFID input
                location.reload(); // Reload the page
                setTimeout(() => document.getElementById('rfid').focus(), 500); // Focus on RFID after reload
            });
        }

        // Show error notification with SweetAlert
        function showErrorAlert(message) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message,
                showConfirmButton: true,
            }).then(() => {
                // After clicking OK, reload the page and focus on RFID input
                location.reload(); // Reload the page
                setTimeout(() => document.getElementById('rfid').focus(), 500); // Focus on RFID after reload
            });
        }

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>