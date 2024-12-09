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
$base_path = "/Newram/superadmin/";
?>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Popper.js (required for Bootstrap's dropdowns and tooltips) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
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
            <?php if ($role === 'Superadmin') { ?>
                <!-- Admin Menu -->
                <li>
                    <a href="#adminSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><span
                            class="fa fa-cogs"></span> Admin</a>
                    <ul class="collapse list-unstyled" id="adminSubmenu">
                        <li class="active"><a href="<?php echo $base_path; ?>admin/admindashboard.php"><span
                                    class="fa fa-home"></span>
                                Dashboard</a></li>
                        <li><a href="<?php echo $base_path; ?>admin/register.php"><span class="fa fa-user"></span>
                                Registration</a>
                        </li>
                        <li><a href="<?php echo $base_path; ?>admin/activate.php"><span class="fa fa-sticky-note"></span>
                                Activation</a></li>
                        <li><a href="<?php echo $base_path; ?>admin/deactivate.php"><span class="fa fa-sticky-note"></span>
                                Deactivation</a>
                        </li>
                        <li><a href="<?php echo $base_path; ?>admin/revenue.php"><span class="fa fa-cogs"></span>
                                Revenue</a></li>
                        <li><a href="<?php echo $base_path; ?>admin/fareupdate.php"><span class="fa fa-arrow-up-1-9"></span>
                                Fare Update</a>
                        </li>
                        <li><a href="<?php echo $base_path; ?>admin/businfo.php"><span class="fa fa-bus"></span> Reg Bus
                                Info</a></li>
                        <li><a href="<?php echo $base_path; ?>admin/busviewinfo.php"><span class="fa fa-eye"></span> View
                                Bus Info</a></li>
                    </ul>
                </li>

                <!-- Cashier Menu -->
                <li>
                    <a href="#cashierSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><span
                            class="fa fa-credit-card"></span> Cashier</a>
                    <ul class="collapse list-unstyled" id="cashierSubmenu">
                        <li class="active"><a href="<?php echo $base_path; ?>cashier/cashierdashboard.php"><span
                                    class="fa fa-tachometer-alt"></span> Dashboard</a></li>
                        <li><a href="<?php echo $base_path; ?>cashier/loadrfidadmin.php"><span
                                    class="fa fa-credit-card"></span>
                                Load
                                RFID</a>
                        </li>
                        <li><a href="<?php echo $base_path; ?>cashier/translogscashier.php"><span
                                    class="fa fa-list-alt"></span> Load
                                Transaction</a></li>
                        <li><a href="<?php echo $base_path; ?>cashier/loadtranscashier.php"><span
                                    class="fa fa-chart-line"></span> Load
                                Revenue</a></li>
                    </ul>
                </li>

                <!-- Conductor Menu -->
                <li>
                    <a href="#conductorSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><span
                            class="fa fa-bus"></span> Conductor</a>
                    <ul class="collapse list-unstyled" id="conductorSubmenu">
                        <li class="active"><a href="<?php echo $base_path; ?>conductor/conductordashboard.php"><span
                                    class="fa fa-tachometer-alt"></span> Dashboard</a></li>
                        <li><a href="<?php echo $base_path; ?>conductor/busfare.php"><span class="fa fa-bus"></span> Bus
                                Fare</a></li>
                        <li><a href="<?php echo $base_path; ?>conductor/passengerlists.php"><span
                                    class="fa fa-users"></span> Passenger
                                Lists</a></li>
                        <li><a href="<?php echo $base_path; ?>conductor/loadrfidconductor.php"><span
                                    class="fa fa-id-badge"></span> Load
                                RFID</a></li>
                        <li><a href="<?php echo $base_path; ?>conductor/translogscon.php"><span
                                    class="fa fa-history"></span> Load
                                Transaction</a></li>
                        <li><a href="<?php echo $base_path; ?>conductor/loadtranscon.php"><span
                                    class="fa fa-dollar-sign"></span> Load
                                Revenue</a></li>
                        <li><a href="<?php echo $base_path; ?>conductor/remitcon.php"><span
                                    class="fa fa-paper-plane"></span> Remit</a></li>
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

    </nav>