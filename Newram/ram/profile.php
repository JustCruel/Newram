<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: log-in.php");
    exit;
}

include 'sidebar.php'; // Include your sidebar plugin
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .profile-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            color: rgb(87, 107, 237);
            text-align: center;
        }

        .profile-info {
            margin-top: 20px;
        }

        .profile-info p {
            margin: 10px 0;
            font-size: 16px;
        }

        .profile-info span {
            font-weight: bold;
            color: rgb(87, 107, 237);
        }

        .update-btn,
        .back-btn {
            display: inline-block;
            background-color: rgb(87, 107, 237);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .btn-container {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="profile-container">
        <h1>My Profile</h1>
        <div class="profile-info">
            <p><span>Email:</span> <?php echo $_SESSION['email']; ?></p>
            <p><span>Name:</span>
                <?php echo $_SESSION['firstname'] . ' ' . $_SESSION['middlename'] . ' ' . $_SESSION['lastname']; ?></p>
            <p><span>Birthday:</span> <?php echo $_SESSION['birthday']; ?></p>
            <p><span>Age:</span> <?php echo $_SESSION['age']; ?></p>
            <p><span>Contact:</span> <?php echo $_SESSION['contactnumber']; ?></p>
            <p><span>Gender:</span> <?php echo $_SESSION['gender']; ?></p>
            <p><span>Address:</span> <?php echo $_SESSION['address']; ?></p>
        </div>
        <div class="btn-container">
            <a href="updateinfo.php" class="update-btn"> Edit Profile</a>
            <a href="javascript:history.back()" class="back-btn">Go Back</a>
        </div>
    </div>

    <script>
        // Any additional JavaScript can go here
    </script>
</body>

</html>