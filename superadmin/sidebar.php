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


<div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar" class="active">
        <h1>
            <a class="logo">
                <img src="../assets/logo/logoramstar.jpg" alt="logo" />
            </a>
        </h1>

        <div class="user-profile text-center mb-3">
            <?php if (!empty($profile_picture)) { ?>
                <img src="../images/<?php echo $profile_picture; ?>" alt="Profile Picture" class="img-fluid rounded-circle"
                    width="100" height="100">
            <?php } else { ?>
                <img src="../images/default_profile.jpg" alt="Default Profile Picture" class="img-fluid rounded-circle"
                    width="100" height="100">
            <?php } ?>
            <h3><?php echo $firstname . " " . $lastname; ?></h3>
            <h3><?php echo ucfirst($role); ?></h3>
        </div>

        <ul class="list-unstyled components mb-5">
            <?php if ($role === 'Superadmin') { ?>
                <!-- Admin Menu -->
                <li class="nav-item">
                    <a href="#adminSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="fa fa-cogs"></span> Admin
                    </a>
                    <ul class="collapse list-unstyled ps-3" id="adminSubmenu">
                        <li><a href="<?php echo $base_path; ?>superadmin.php" class="nav-link"><i
                                    class="fa fa-home me-2"></i> Dashboard</a></li>
                        <li><a href="<?php echo $base_path; ?>admin/register.php" class="nav-link"><i
                                    class="fa fa-user me-2"></i> Registration</a></li>
                        <li><a href="<?php echo $base_path; ?>admin/activate.php" class="nav-link"><i
                                    class="fa fa-sticky-note me-2"></i> Accounts</a></li>
                        <li><a href="<?php echo $base_path; ?>admin/revenue.php" class="nav-link"><i
                                    class="fa fa-cogs me-2"></i> Revenue</a></li>
                        <li><a href="<?php echo $base_path; ?>admin/fareupdate.php" class="nav-link"><i
                                    class="fa fa-arrow-up-1-9 me-2"></i> Fare Update</a></li>
                        <li><a href="<?php echo $base_path; ?>admin/businfo.php" class="nav-link"><i
                                    class="fa fa-bus me-2"></i> Reg Bus Info</a></li>
                        <li><a href="<?php echo $base_path; ?>admin/busviewinfo.php" class="nav-link"><i
                                    class="fa fa-eye me-2"></i> Today's Bus Info</a></li>
                        <li><a href="<?php echo $base_path; ?>admin/viewregbus.php" class="nav-link"><i
                                    class="fa fa-eye me-2"></i> Registered Bus Info</a></li>
                        <li><a href="<?php echo $base_path; ?>admin/activity_logs.php" class="nav-link"><i
                                    class="fa fa-home me-2"></i> Activity Logs</a></li>
                    </ul>
                </li>
                <hr style="border: 1px solid white;">


                <!-- Cashier Menu -->
                <li class="nav-item">
                    <a href="#cashierSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="fa fa-credit-card"></span> Cashier
                    </a>
                    <ul class="collapse list-unstyled ps-3" id="cashierSubmenu">
                        <li><a href="<?php echo $base_path; ?>cashier/loadrfidadmin.php" class="nav-link"><i
                                    class="fa fa-credit-card me-2"></i> Load RFID</a></li>
                        <li><a href="<?php echo $base_path; ?>cashier/remitcashier.php" class="nav-link"><i
                                    class="fa fa-chart-line me-2"></i> Remit</a></li>
                        <li><a href="<?php echo $base_path; ?>cashier/translogscashier.php" class="nav-link"><i
                                    class="fa fa-list-alt me-2"></i> Load Transaction</a></li>
                        <li><a href="<?php echo $base_path; ?>cashier/remit_logs.php" class="nav-link"><i
                                    class="fa fa-list-alt me-2"></i> Remit Logs</a></li>
                        <li><a href="<?php echo $base_path; ?>cashier/loadtranscashier.php" class="nav-link"><i
                                    class="fa fa-chart-line me-2"></i> Load Revenue</a></li>
                    </ul>
                </li>
                <hr style="border: 1px solid white;">


                <!-- Conductor Menu -->
                <li class="nav-item">
                    <a href="#conductorSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="fa fa-bus"></span> Conductor
                    </a>
                    <ul class="collapse list-unstyled ps-3" id="conductorSubmenu">
                        <li><a href="<?php echo $base_path; ?>conductor/busfare.php" class="nav-link"><i
                                    class="fa fa-bus me-2"></i> Bus Fare</a></li>
                        <li><a href="<?php echo $base_path; ?>conductor/loadrfidconductor.php" class="nav-link"><i
                                    class="fa fa-id-badge me-2"></i> Load RFID</a></li>
                        <li><a href="<?php echo $base_path; ?>conductor/translogscon.php" class="nav-link"><i
                                    class="fa fa-history me-2"></i> Load Transaction</a></li>
                        <li><a href="<?php echo $base_path; ?>conductor/loadtranscon.php" class="nav-link"><i
                                    class="fa fa-dollar-sign me-2"></i> Load Revenue</a></li>
                        <li><a href="<?php echo $base_path; ?>conductor/remitcon.php" class="nav-link"><i
                                    class="fa fa-paper-plane me-2"></i> Remit</a></li>
                    </ul>
                </li>
                <hr style="border: 1px solid white;">


                <!-- User Menu -->
                <li class="nav-item">
                    <a href="#userSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="fa fa-coins"></span> User
                    </a>
                    <ul class="collapse list-unstyled ps-3" id="userSubmenu">
                        <li><a href="<?php echo $base_path; ?>users/recent_trips.php" class="nav-link"><i
                                    class="fa fa-id-card me-2"></i> Recent Trips</a></li>
                        <li><a href="<?php echo $base_path; ?>users/convert_points.php" class="nav-link"><i
                                    class="fa fa-coins me-2"></i> Convert Points</a></li>
                        <li><a href="<?php echo $base_path; ?>users/updatepass.php" class="nav-link"><i
                                    class="fa fa-file-alt me-2"></i> Update Password</a></li>
                        <li><a href="<?php echo $base_path; ?>users/transactionlogs.php" class="nav-link"><i
                                    class="fa fa-paper-plane me-2"></i> Transaction Logs</a></li>
                    </ul>
                </li>
                <hr style="border: 1px solid white;">


                <!-- Logout -->
                <li class="nav-item">
                    <a href="/Newram/logout.php">
                        <span class="fa fa-sign-out-alt"></span> Logout
                    </a>
                </li>
                <hr style="border: 1px solid white;">

            <?php } ?>
        </ul>
    </nav>


    <div id="content" class="p-4 p-md-5">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-primary" onclick="toggleSidebar(event)">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>


            </div>
        </nav>