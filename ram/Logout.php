<?php
session_start();
include 'config/connection.php';

if (isset($_POST['confirm_logout']) && $_POST['confirm_logout'] == 'true') {
	$email = $_SESSION['email'];
	$id = $_SESSION['audit_id'];
	$currentDateTime = date('Y-m-d H:i:s');

	// Prepare the SQL statement to prevent SQL injection
	$stmt = $conn->prepare("UPDATE audit SET logouttime = ? WHERE audit_id = ?");
	if ($stmt) {
		$stmt->bind_param("si", $currentDateTime, $id);

		if ($stmt->execute()) {
			session_destroy();
		} else {
			// Handle error
		}
		$stmt->close();
	} else {
		// Handle error
	}
	exit;
} else {
	// Handle error
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
	<script>Swal.fire({
			title: 'Are you sure?',
			text: "You will be logged out of the system.",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, log me out!'
		}).then((result) => {
			if (result.isConfirmed) {
				fetch('logout.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
					},
					body: 'confirm_logout=true'
				})
					.then(() => {
						Swal.fire(
							'Logged Out!',
							'You have been successfully logged out.',
							'success'
						).then(() => {
							setTimeout(() => {
								window.location.href = 'Home.php';
							}, 100); // Wait 2 seconds before redirecting
						});
					})
					.catch((error) => {
						console.error('Error:', error);
						Swal.fire(
							'Error',
							'An error occurred while logging out.',
							'error'
						);
					});
			} else {
				window.history.back();
			}
		});
	</script>
</body>

</html>