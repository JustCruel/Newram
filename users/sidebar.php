<?php
if (isset($_SESSION['firstname']) && isset($_SESSION['lastname'])) {
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
} else {
    // Handle case where session variables are not set
    $firstname = 'Guest';
    $lastname = '';
}
?>

<div class="wrapper d-flex align-items-stretch">

    <nav id="sidebar" class="active">

        <h1><a href="index.php" class="logo">
                <img src="../assets/logo/logoramstar.jpg" alt="logo" />
            </a></h1>
        <div class="user-profile text-center mb-3">
            <?php if (!empty($profile_picture)) { ?>
                <img src="../images/<?php echo $profile_picture; ?>" alt="Profile Picture" class="img-fluid rounded-circle"
                    width="100" height="100">
            <?php } else { ?>
                <img src="../images/default_profile.jpg" alt="Default Profile Picture" class="img-fluid rounded-circle"
                    width="100" height="100">
            <?php } ?>
            <h3><?php echo $firstname, " ", $lastname; ?></h3>
        </div>
        <ul class="list-unstyled components mb-5">
            <li class="active">
                <a href="./index.php"><span class="fa fa-tachometer-alt"></span>
                    Dashboard</a>
            </li>
            <li>
                <a href="recent_trips.php"><span class="fa fa-id-card"></span>
                    Recent Trips</a>
            </li>
            <li>
                <a href="bus_tracking.php"><span class="fa fa-bus"></span>
                    Track Bus</a>
            </li>
            <li>
                <a href="convert_points.php"><span class="fa fa-coins"></span>
                    Convert Points</a>
            </li>
            <li>
                <a href="updatepass.php"><span class="fa fa-key"></span>
                    Update Password</a>
            </li>
            <li>
                <a href="transactionlogs.php"><span class="fa fa-file-alt"></span>
                    Transaction logs</a>
            </li>
            <li>
                <a href="../logout.php"><span class="fa fa-sign-out-alt"></span> Logout</a>
            </li>

        </ul>

    </nav>