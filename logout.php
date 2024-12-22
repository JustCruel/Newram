<?php
session_start();
include 'config/connection.php';

$response = ['success' => false, 'message' => ''];

if (isset($_POST['confirm_logout']) && $_POST['confirm_logout'] === 'true') {
	// Check if it's a conductor's session
	if (isset($_SESSION['bus_number'], $_SESSION['driver_account_number'], $_SESSION['email'])) {
		$bus_number = $_SESSION['bus_number'];
		$conductor_id = $_SESSION['driver_account_number'];
		$email = $_SESSION['email'];

		// Update the bus status to 'Available'
		$updateBusStmt = $conn->prepare("UPDATE businfo SET status = 'Available' WHERE bus_number = ?");
		if ($updateBusStmt) {
			$updateBusStmt->bind_param("s", $bus_number);
			if ($updateBusStmt->execute()) {
				session_destroy(); // End the session
				$response = ['success' => true, 'message' => 'Conductor logged out successfully.'];
			} else {
				$response = ['error' => 'Error updating bus status: ' . $conn->error];
			}
			$updateBusStmt->close();
		} else {
			$response = ['error' => 'Error preparing bus update statement: ' . $conn->error];
		}
	}
	// Check if it's a regular user session
	elseif (isset($_POST['confirm_logout'])) {
		// Unset all session variables
		session_unset();

		// Destroy the session
		session_destroy();

		// Return a success message as JSON
		echo json_encode(['success' => 'You have been logged out successfully!']);
		exit();
	}

	echo json_encode($response);
	exit();
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
				fetch('logout.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
					},
					body: new URLSearchParams({ confirm_logout: 'true' })
				})
					.then(response => response.json())
					.then(data => {
						if (data.success) {
							Swal.fire({
    title: 'Logged Out!',
    text: data.message,
    icon: 'success',
    showConfirmButton: false,  // Disable the "OK" button
    timer: 1500  // Optionally, you can add a timer to auto-close after 1.5 seconds
}).then(() => {
    window.location.href = 'login.php';  // Redirect to the login page after the alert
});

						} else {
							Swal.fire('Error', data.error || 'An error occurred during logout.', 'error');
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