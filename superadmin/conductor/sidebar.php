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
                <a href="#adminSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><span
                        class="fa fa-tachometer-alt"></span> Admin</a>
                <ul class="collapse list-unstyled" id="adminSubmenu">
                    <li><a href="admin/index.php">Admin Dashboard</a></li>
                    <li><a href="admin/register.php">Registration </a></li>
                    <li><a href="admin/activate.php">Activation</a></li>
                    <li><a href="admin/deactivate.php">Deactivation</a></li>
                    <li><a href="admin/revenue.php">Revenue</a></li>
                    <li><a href="admin/fareupdate.php">Fare Update</a></li>
                    <li><a href="admin/businfo.php">Reg Bus Info</a></li>
                    <li><a href="admin/busviewinfo.php">View bus Info</a></li>
                </ul>
            </li>
            <li>
                <a href="#cashierSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><span
                        class="fa fa-id-card"></span> Cashier</a>
                <ul class="collapse list-unstyled" id="cashierSubmenu">
                    <li><a href="cashier/index.php">Cashier Dashboard</a></li>
                    <li><a href="cashier/loadrfid.php">Load RFID</a></li>
                    <li><a href="cashier/transactionlogs.php">Load Transactions</a></li>
                    <li><a href="cashier/loadtransactions.php">Load Revenue</a></li>
                </ul>
            </li>
            <li>
                <a href="#conductorSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><span
                        class="fa fa-bus"></span> Conductor</a>
                <ul class="collapse list-unstyled" id="conductorSubmenu">
                    <li><a href="">View Rides</a></li>
                    <li><a href="">Manage Fares</a></li>
                </ul>
            </li>
            <li>
                <a href="#userSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><span
                        class="fa fa-coins"></span> User</a>
                <ul class="collapse list-unstyled" id="userSubmenu">
                    <li><a href="">View Balance</a></li>
                    <li><a href="">Transaction History</a></li>
                    <li><a href="">Update Profile</a></li>
                </ul>
            </li>

            <li>
                <a href="../logout.php"><span class="fa fa-sign-out-alt"></span> Logout</a>
            </li>

        </ul>

    </nav>