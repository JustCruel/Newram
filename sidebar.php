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
<!--
<!-- Bootstrap 4 CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<!-- Popper.js (for tooltips and popovers) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>

<!-- Bootstrap 4 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


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
            <h3><?php echo ucfirst($role); ?></h3>
        </div>
        <ul class="list-unstyled components mb-5">
            <?php if ($role === 'Admin') { ?>
                <ul class="list-unstyled components mb-5">
                    <li class="active">
                        <a href="admindashboard.php"><span class="fa fa-home"></span>
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
                        <a href="../logout.php"><span class="fa fa-sign-out-alt"></span> Logout</a>
                    </li>
                </ul>
            <?php } ?>

            <?php if ($role === 'Cashier') { ?>
                <ul class="list-unstyled components mb-5">
                    <li class="active">
                        <a href="./cashierdashboard.php"><span class="fa fa-tachometer-alt"></span>
                            Dashboard</a>
                    </li>
                    <li>
                        <a href="./loadrfidadmin.php"><span class="fa fa-credit-card"></span>
                            Load RFID</a>
                    </li>
                    <!-- <li>
                        <a href="./activatecashier.php"><span class="fa fa-bolt"></span>
                            Activation</a>
                    </li> -->
                    <li>
                        <a href="./translogscashier.php"><span class="fa fa-list-alt"></span>
                            Load Transaction</a>
                    </li>
                    <li>
                        <a href="./loadtranscashier.php"><span class="fa fa-chart-line"></span>
                            Load Revenue</a>
                    </li>
                    <li>
                        <a href="../logout.php"><span class="fa fa-sign-out-alt"></span> Logout</a>
                    </li>
                </ul>
            <?php } ?>

            <?php if ($role === 'Conductor') { ?>
                <ul class="list-unstyled components mb-5">
                    <li class="active">
                        <a href="./conductordashboard.php"><span class="fa fa-tachometer-alt"></span> Dashboard</a>
                    </li>
                    <li>
                        <a href="./busfare.php"><span class="fa fa-bus"></span> Bus Fare</a>
                    </li>
                    <li>
                        <a href="./passengerlists.php"><span class="fa fa-users"></span> Passenger Lists</a>
                    </li>
                    <li>
                        <a href="./loadrfidconductor.php"><span class="fa fa-id-badge"></span> Load RFID</a>
                    </li>
                    <li>
                        <a href="./translogscon.php"><span class="fa fa-history"></span> Load Transaction</a>
                    </li>
                    <li>
                        <a href="./loadtranscon.php"><span class="fa fa-dollar-sign"></span> Load Revenue</a>
                    </li>
                    <li>
                        <a href="./remitcon.php"><span class="fa fa-paper-plane"></span> Remit</a>
                    </li>
                    <li>
                        <a href="../logout.php"><span class="fa fa-sign-out-alt"></span> Logout</a>
                    </li>
                <?php } ?>

                <?php if ($role === 'User') { ?>
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

                    <li>
                        <a href="../logout.php"><span class="fa fa-sign-out-alt"></span> Logout</a>
                    </li>
                <?php } ?>
            </ul>
            <ul class="list-unstyled components mb-5">
                <?php if ($role === 'Superadmin') { ?>
                    <!-- Admin Menu -->
                    <li>
                        <a href="#adminSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><span
                                class="fa fa-cogs"></span> Admin</a>
                        <ul class="collapse list-unstyled" id="adminSubmenu">
                            <li class="active"><a href="../admin/admindashboard.php"><span class="fa fa-home"></span>
                                    Dashboard</a></li>
                            <li><a href="../admin/register.php"><span class="fa fa-user"></span> Registration</a></li>
                            <li><a href="../admin/activate.php"><span class="fa fa-sticky-note"></span> Activation</a></li>
                            <li><a href="../admin/deactivate.php"><span class="fa fa-sticky-note"></span> Deactivation</a>
                            </li>
                            <li><a href="../admin/revenue.php"><span class="fa fa-cogs"></span> Revenue</a></li>
                            <li><a href="../admin/fareupdate.php"><span class="fa fa-arrow-up-1-9"></span> Fare Update</a>
                            </li>
                            <li><a href="../admin/businfo.php"><span class="fa fa-bus"></span> Reg Bus Info</a></li>
                            <li><a href="../admin/busviewinfo.php"><span class="fa fa-eye"></span> View Bus Info</a></li>
                        </ul>
                    </li>

                    <!-- Cashier Menu -->
                    <li>
                        <a href="#cashierSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><span
                                class="fa fa-credit-card"></span> Cashier</a>
                        <ul class="collapse list-unstyled" id="cashierSubmenu">
                            <li class="active"><a href="../cashier/cashierdashboard.php"><span
                                        class="fa fa-tachometer-alt"></span> Dashboard</a></li>
                            <li><a href="../cashier/loadrfidadmin.php"><span class="fa fa-credit-card"></span> Load RFID</a>
                            </li>
                            <li><a href="../cashier/translogscashier.php"><span class="fa fa-list-alt"></span> Load
                                    Transaction</a></li>
                            <li><a href="../cashier/loadtranscashier.php"><span class="fa fa-chart-line"></span> Load
                                    Revenue</a></li>
                        </ul>
                    </li>

                    <!-- Conductor Menu -->
                    <li>
                        <a href="#conductorSubmenu" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle"><span class="fa fa-bus"></span> Conductor</a>
                        <ul class="collapse list-unstyled" id="conductorSubmenu">
                            <li class="active"><a href="../conductor/conductordashboard.php"><span
                                        class="fa fa-tachometer-alt"></span> Dashboard</a></li>
                            <li><a href="../conductor/busfare.php"><span class="fa fa-bus"></span> Bus Fare</a></li>
                            <li><a href="../conductor/passengerlists.php"><span class="fa fa-users"></span> Passenger
                                    Lists</a></li>
                            <li><a href="../conductor/loadrfidconductor.php"><span class="fa fa-id-badge"></span> Load
                                    RFID</a></li>
                            <li><a href="../conductor/translogscon.php"><span class="fa fa-history"></span> Load
                                    Transaction</a></li>
                            <li><a href="../conductor/loadtranscon.php"><span class="fa fa-dollar-sign"></span> Load
                                    Revenue</a></li>
                            <li><a href="../conductor/remitcon.php"><span class="fa fa-paper-plane"></span> Remit</a></li>
                        </ul>
                    </li>

                    <!-- User Submenu -->
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

                    <!-- Logout -->
                    <li><a href="../logout.php"><span class="fa fa-sign-out-alt"></span> Logout</a></li>
                <?php } ?>
            </ul>

    </nav> -->