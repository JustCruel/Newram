<?php
session_start();
include 'config/connection.php';

if (!isset($_SESSION['bus_number'], $_SESSION['driver_account_number'], $_SESSION['email'])) {
	echo json_encode(['error' => 'Required session variables are missing.']);
	exit;
}

$bus_number = $_SESSION['bus_number'];
$conductor_id = $_SESSION['driver_account_number'];
$email = $_SESSION['email'];

if (isset($_POST['confirm_logout']) && $_POST['confirm_logout'] === 'true') {
	// Prepare the update query
	$updateBusStmt = $conn->prepare("UPDATE businfo SET status = 'Available', driverName = '', conductorName = '' WHERE bus_number = ?");

	if ($updateBusStmt) {
		$updateBusStmt->bind_param("s", $bus_number);

		if ($updateBusStmt->execute()) {
			// Session destruction and response sending only after successful database update
			session_destroy(); // End the session
			echo json_encode(['success' => 'Logged out successfully.']);
		} else {
			echo json_encode(['error' => 'Error updating bus status: ' . $conn->error]);
		}

		$updateBusStmt->close();
	} else {
		echo json_encode(['error' => 'Error preparing bus update statement: ' . $conn->error]);
	}

	exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Logout</title>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
	<script>
		Swal.fire({
			title: 'Are you sure?',
			text: "You will be logged out of the system.",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, log me out!'
		}).then((result) => {
			if (result.isConfirmed) {
				// If confirmed, log the user out
				fetch('logoutc.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
					},
					body: new URLSearchParams({ confirm_logout: 'true' })
				})
					.then(response => response.json())
					.then(data => {
						if (data.success) {
							Swal.fire('Logged Out!', data.success, 'success')
								.then(() => window.location.href = 'index.php'); // Redirect after successful logout
						} else {
							Swal.fire('Error', data.error, 'error');
							window.history.back(); // Go back to the previous page
						}
					})
					.catch(error => {
						Swal.fire('Error', 'An error occurred while logging out.', 'error');
					});
			} else {
				// If cancel, navigate back
				window.history.back();
			}
		});
	</script>
</body>

</html>