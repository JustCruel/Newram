<?php
session_start();
ob_start();

// Check if the user is logged in by checking session variables
if (isset($_POST['confirm_logout'])) {
	// Unset all session variables
	session_unset();

	// Destroy the session
	session_destroy();

	// Return a success message as JSON
	echo json_encode(['success' => 'You have been logged out successfully!']);
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
					body: new URLSearchParams({ confirm_logout: 'true' }) // Ensure correct data format
				})
					.then(response => response.json())
					.then(data => {
						console.log(data); // Log the response from the backend
						if (data.success) {
							Swal.fire('Logged Out!', data.success, 'success')
								.then(() => window.location.href = 'index.php');
						} else {
							Swal.fire('Error', 'An error occurred during logout.', 'error');
							window.history.back(); // Go back to the previous page
						}
					})
					.catch(error => {
						console.error('Error:', error); // Log any errors
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