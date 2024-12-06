<?php
session_start();
include '../config/connection.php';

$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];

// Fetch fare settings from the database
$query = "SELECT * FROM fare_settings LIMIT 1";
$result = $conn->query($query);
$fareSettings = $result->fetch_assoc();

// Update fare settings if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $baseFare = $_POST['base_fare'];
    $additionalFare = $_POST['additional_fare'];

    // Update the fare settings in the database
    $updateQuery = "UPDATE fare_settings SET base_fare = ?, additional_fare = ? WHERE id = 1";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("dd", $baseFare, $additionalFare);
    $stmt->execute();
    $stmt->close();

    // Set session variable for SweetAlert success
    $_SESSION['fare_updated'] = true;

    // Reload the page to reflect updated fare settings
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fare Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        h1.text-center {
            color: #000;
        }
    </style>
</head>

<body>

    <?php
    include 'sidebar.php';

    // Check if fare settings were updated and show SweetAlert
    if (isset($_SESSION['fare_updated']) && $_SESSION['fare_updated']) {
        echo '<script>
                Swal.fire({
                    title: "Success!",
                    text: "Fare settings have been updated.",
                    icon: "success",
                    confirmButtonText: "Okay"
                });
              </script>';
        unset($_SESSION['fare_updated']);
    }
    ?>

    <div class="container mt-5">
        <h1 class="text-center">Fare Settings</h1>

        <form method="POST" class="mt-4">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="base_fare" class="form-label">Base Fare (₱) First 4 Km</label>
                    <input type="number" id="base_fare" name="base_fare" class="form-control" placeholder="14.00"
                        step="0.01" value="<?= htmlspecialchars($fareSettings['base_fare']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="additional_fare" class="form-label">Additional Fare per Km (₱)</label>
                    <input type="number" id="additional_fare" name="additional_fare" class="form-control" step="0.01"
                        value="<?= htmlspecialchars($fareSettings['additional_fare']) ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 offset-md-3">
                    <button type="submit" class="btn btn-primary btn-lg w-100">Save Fare Settings</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent the form from submitting immediately

            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to update the fares?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, save it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the form
                    e.target.submit();
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>