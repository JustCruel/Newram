<?php
session_start();
include "config/connection.php"; // Ensure this file connects to your database

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare a statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, password FROM userss WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, start the session
            $_SESSION['user_id'] = $id; // Store user ID in session
            $_SESSION['username'] = $username; // Store username in session
            echo "<div class='alert alert-success' role='alert'>Login successful! Welcome, $username.</div>";
            // Redirect to a secure page or user dashboard
            header("Location: dashboardhome.php"); // Change this to your desired landing page
            exit();
        } else {
            echo "<div class='alert alert-danger' role='alert'>Invalid password. Please try again.</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>User not found. Please register.</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login Form</title>
</head>

<body>
    <div class="container mt-5">
        <h2>Login Form</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>

</html>