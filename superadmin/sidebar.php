<?php
if (isset($_SESSION['firstname']) && isset($_SESSION['lastname'])) {
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : 'Guest';
} else {
    // Handle case where session variables are not set
    $firstname = 'Guest';
    $lastname = '';
    $role = 'Guest';
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
            <h5><?php echo ucfirst($role); ?></h5>
        </div>
        <ul class="list-unstyled components mb-5">
            <?php if ($role === 'Superadmin' || $role === 'Admin') { ?>
                <li class="active">
                    <a href="#adminSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><span
                            class="fa fa-tachometer-alt"></span> Admin</a>
                    <ul class="collapse list-unstyled" id="adminSubmenu">
                        <li><a href="indexadmin.php">Admin Dashboard</a></li>
                        <li><a href="register.php">Registration</a></li>
                        <li><a href="activate.php">Activation</a></li>
                        <li><a href="deactivate.php">Deactivation</a></li>
                        <li><a href="revenue.php">Revenue</a></li>
                        <li><a href="fareupdate.php">Fare Update</a></li>
                        <li><a href="businfo.php">Reg Bus Info</a></li>
                        <li><a href="busviewinfo.php">View Bus Info</a></li>
                    </ul>
                </li>
            <?php } ?>

            <?php if ($role === 'Superadmin' || $role === 'Cashier') { ?>
                <li>
                    <a href="#cashierSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><span
                            class="fa fa-id-card"></span> Cashier</a>
                    <ul class="collapse list-unstyled" id="cashierSubmenu">
                        <li><a href="indexcashier.php">Cashier Dashboard</a></li>
                        <li><a href="loadrfid.php">Load RFID</a></li>
                        <li><a href="transactionlogs.php">Load Transactions</a></li>
                        <li><a href="loadtransactions.php">Load Revenue</a></li>
                    </ul>
                </li>
            <?php } ?>

            <?php if ($role === 'Superadmin' || $role === 'Conductor') { ?>
                <li>
                    <a href="#conductorSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><span
                            class="fa fa-bus"></span> Conductor</a>
                    <ul class="collapse list-unstyled" id="conductorSubmenu">
                        <li><a href="indexcon.php">Conductor Dashboard</a></li>
                        <li><a href="busfarenew1.php">Bus Fare</a></li>
                        <li><a href="passengerlists.php">Passenger List</a></li>
                        <li><a href="loadrfid.php">Load RFID</a></li>
                        <li><a href="transactionlogs.php">Load Transactions</a></li>
                        <li><a href="remit.php">Remit</a></li>
                    </ul>
                </li>
            <?php } ?>

            <?php if ($role === 'Superadmin' || $role === 'User') { ?>
                <li>
                    <a href="#userSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><span
                            class="fa fa-coins"></span> User</a>
                    <ul class="collapse list-unstyled" id="userSubmenu">
                        <li><a href="">User Dashboard</a></li>
                        <li><a href="recent_trips.php">Recent Trips</a></li>
                        <li><a href="bus_tracking.php">Track Bus</a></li>
                        <li><a href="convert_points.php">View Balance</a></li>
                        <li><a href="">Transaction History</a></li>
                        <li><a href="">Update Profile</a></li>
                    </ul>
                </li>
            <?php } ?>

            <li>
                <a href="../logout.php"><span class="fa fa-sign-out-alt"></span> Logout</a>
            </li>
        </ul>

    </nav>
</div>