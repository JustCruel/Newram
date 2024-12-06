<?php
session_start();
include '../config/connection.php';

$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['dashboard'])) {
    // Fetch passengers currently on board
    $passengers = $_SESSION['passengers'];

    // Group passengers by destination and count them
    $destinationCount = [];

    foreach ($passengers as $passenger) {
        $destination = $passenger['toRoute']['route_name'];

        // Initialize the destination count if not already set
        if (!isset($destinationCount[$destination])) {
            $destinationCount[$destination] = 0;
        }

        // Check if this passenger has already been counted (if already exists, subtract 1)
        if (isset($passenger['getOff']) && $passenger['getOff'] === true) {
            $destinationCount[$destination]--; // Remove one passenger
        } else {
            $destinationCount[$destination]++; // Add one passenger
        }

        // Ensure the count doesn't go negative
        if ($destinationCount[$destination] < 0) {
            $destinationCount[$destination] = 0; // Reset to zero if negative
        }
    }

    // Return the grouped data to the driver
    echo json_encode([
        'status' => 'success',
        'destination_count' => $destinationCount
    ]);
    exit;
}

// Handle passenger removal
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['removePassenger'])) {
    $destination = $_GET['destination'];

    // Logic to find and update the passenger's 'getOff' status
    $passengers = &$_SESSION['passengers'];

    foreach ($passengers as &$passenger) {
        if ($passenger['toRoute']['route_name'] === $destination && !isset($passenger['getOff'])) {
            $passenger['getOff'] = true; // Mark the passenger as gotten off
            break;
        }
    }

    echo json_encode(['status' => 'success']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 8px;
        }

        .form-label {
            font-weight: 600;
        }

        .table th,
        .table td {
            text-align: center;
        }

        .header {
            text-align: center;
            margin-top: 20px;
        }

        .btn-refresh {
            margin-bottom: 20px;
        }

        .card-header h4 {
            color: #000;
            /* Change this color to your desired color */
        }
    </style>
</head>

<body>
    <?php
    include 'sidebar.php'
        ?>
    <div class="container mt-5">
        <div class="header">
            <h1 class="text-primary">Passengers</h1>
            <p>View destinations and the number of passengers getting off at each destination</p>
        </div>

        <div class="card shadow-sm mb-5">
            <div class="card-header">
                <h4>Passenger Destinations</h4>
            </div>
            <div class="card-body">
                <table id="destinationTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Destination</th>
                            <th>Number of Passengers</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Destination rows will be inserted here dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        async function fetchDashboardData() {
            try {
                const response = await fetch('<?= $_SERVER['PHP_SELF']; ?>?dashboard=true', {
                    method: 'GET',
                });

                const data = await response.json();
                if (data.status === 'success') {
                    updateDashboard(data);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Unable to fetch destination data.',
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! Try again.',
                });
            }
        }

        function updateDashboard(data) {
            // Update destination table
            const tableBody = document.querySelector("#destinationTable tbody");
            tableBody.innerHTML = ''; // Clear existing rows

            for (const [destination, count] of Object.entries(data.destination_count)) {
                if (count > 0) {
                    const row = document.createElement("tr");

                    row.innerHTML = `
                        <td>${destination}</td>
                        <td>${count}</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="removePassenger('${destination}')">-</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                }
            }
        }

        async function removePassenger(destination) {
            // Prompt for confirmation to remove the passenger
            const result = await Swal.fire({
                title: 'Remove Passenger',
                text: `Are you sure you want to remove a passenger from ${destination}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove',
                cancelButtonText: 'No, cancel'
            });

            if (result.isConfirmed) {
                try {
                    // Send the request to remove a passenger at this destination
                    const response = await fetch('<?= $_SERVER['PHP_SELF']; ?>?removePassenger=true&destination=' + destination, {
                        method: 'GET',
                    });

                    const data = await response.json();
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Passenger Removed',
                            text: 'The passenger has been removed from this destination.',
                        });
                        fetchDashboardData(); // Refresh dashboard
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to remove passenger.',
                        });
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Try again.',
                    });
                }
            }
        }

        // Initialize dashboard on page load
        window.onload = function () {
            fetchDashboardData(); // Fetch data initially
            setInterval(fetchDashboardData, 5000); // Refresh data every 5 seconds
        };
    </script>
</body>

</html>