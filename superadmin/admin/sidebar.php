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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                <a href="./index.php"><span class="fa fa-home"></span>
                    Dashboard</a>
            </li>
            <li>
                <a href="register.php"><span class="fa fa-user"></span>
                    Registration</a>
            </li>
            <li>
                <a href="activate.php"><span class="fa fa-sticky-note"></span>
                    Activation</a>
            </li>
            <li>
                <a href="deactivate.php"><span class="fa fa-sticky-note"></span>
                    Deactivation</a>
            </li>

            <li>
                <a href="revenue.php"><span class="fa fa-cogs"></span>
                    Revenue</a>
            </li>
            <li>
                <a href="fareupdate.php" onclick=""><span class="fa fa-arrow-up-1-9"></span>
                    Fare Update</a>
            </li>
            <li>
                <a href="businfo.php">
                    <span class="fa fa-bus"></span> Reg Bus Info
                </a>
            </li>
            <li>
                <a href="busviewinfo.php">
                    <span class="fa fa-eye"></span> View Bus Info
                </a>
            </li>
            <li>
                <a href="../logout.php">
                    <span class="fa fa-paper-plane"></span> Logout
                </a>
            </li>
        </ul>

        <div class="footer">
            <p>
                Copyright &copy;
                <script>document.write(new Date().getFullYear());</script> All rights reserved | This template is
                made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com"
                    target="_blank">Colorlib.com</a>
            </p>
        </div>
    </nav>