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
            <a href="index.php" class="logo">
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
                    <ul class="collapse list-unstyled" id="adminSubmenu">
                        <!-- <li><a href="<?php echo $base_path; ?>admin/admindashboard.php"><span class="fa fa-home"></span>
                                Dashboard</a></li> -->
                        <li><a href="<?php echo $base_path; ?>admin/register.php"><span class="fa fa-user"></span>
                                Registration</a></li>
                        <li><a href="<?php echo $base_path; ?>admin/activate.php"><span class="fa fa-sticky-note"></span>
                                Accounts</a></li>
                        <li><a href="<?php echo $base_path; ?>admin/revenue.php"><span class="fa fa-cogs"></span>
                                Revenue</a></li>
                        <li><a href="<?php echo $base_path; ?>admin/fareupdate.php"><span class="fa fa-arrow-up-1-9"></span>
                                Fare Update</a></li>
                        <li><a href="<?php echo $base_path; ?>admin/businfo.php"><span class="fa fa-bus"></span> Reg Bus
                                Info</a></li>
                        <li><a href="<?php echo $base_path; ?>admin/busviewinfo.php"><span class="fa fa-eye"></span>
                                Todays Bus Info</a></li>
                                <li><a href="<?php echo $base_path; ?>admin/viewregbus.php"><span class="fa fa-eye"></span>
                               View registered Bus Info</a></li>
                    </ul>
                </li>

                <!-- Cashier Menu -->
                <li class="nav-item">
                    <a href="#cashierSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="fa fa-credit-card"></span> Cashier
                    </a>
                    <ul class="collapse list-unstyled" id="cashierSubmenu">
                        <!--   <li><a href="<?php echo $base_path; ?>cashier/cashierdashboard.php"><span
                                    class="fa fa-tachometer-alt"></span> Dashboard</a></li> -->
                        <li><a href="<?php echo $base_path; ?>cashier/loadrfidadmin.php"><span
                                    class="fa fa-credit-card"></span> Load RFID</a></li>
                        <li><a href="<?php echo $base_path; ?>cashier/translogscashier.php"><span
                                    class="fa fa-list-alt"></span> Load Transaction</a></li>
                        <li><a href="<?php echo $base_path; ?>cashier/loadtranscashier.php"><span
                                    class="fa fa-chart-line"></span> Load Revenue</a></li>
                    </ul>
                </li>

                <!-- Conductor Menu -->
                <li class="nav-item">
                    <a href="#conductorSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="fa fa-bus"></span> Conductor
                    </a>
                    <ul class="collapse list-unstyled" id="conductorSubmenu">
                         <li><a href="<?php echo $base_path; ?>conductor/conductordashboard.php"><span
                                    class="fa fa-tachometer-alt"></span> Dashboard</a></li> 
                        <li><a href="<?php echo $base_path; ?>conductor/busfare.php"><span class="fa fa-bus"></span> Bus
                                Fare</a></li>
                        <li><a href="<?php echo $base_path; ?>conductor/passengerlists.php"><span
                                    class="fa fa-users"></span> Passenger Lists</a></li>
                        <li><a href="<?php echo $base_path; ?>conductor/loadrfidconductor.php"><span
                                    class="fa fa-id-badge"></span> Load RFID</a></li>
                        <li><a href="<?php echo $base_path; ?>conductor/translogscon.php"><span
                                    class="fa fa-history"></span> Load Transaction</a></li>
                        <li><a href="<?php echo $base_path; ?>conductor/loadtranscon.php"><span
                                    class="fa fa-dollar-sign"></span> Load Revenue</a></li>
                        <li><a href="<?php echo $base_path; ?>conductor/remitcon.php"><span
                                    class="fa fa-paper-plane"></span> Remit</a></li>
                    </ul>
                </li>

                <!-- User Menu -->
                <li class="nav-item">
                    <a href="#userSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <span class="fa fa-coins"></span> User
                    </a>
                    <ul class="collapse list-unstyled" id="userSubmenu">
                    <li><a href="<?php echo $base_path; ?>users/userdashboard.php"><span
                                    class="fa fa-tachometer-alt"></span> Dashboard</a></li> 
                        <li><a href="<?php echo $base_path; ?>users/recent_trips.php"><span class="fa fa-id-card"></span> Recent Trips</a></li>
                       
                        <li><a href="<?php echo $base_path; ?>users/convert_points.php"><span
                                    class="fa fa-coins"></span> Convert Points</a></li>
                        <li><a href="<?php echo $base_path; ?>users/updatepass.php"><span
                                    class="fa fa-file-alt"></span> Upgate Password</a></li>
                        <li><a href="<?php echo $base_path; ?>users/transactionlogs.php"><span
                                    class="fa fa-paper-plane"></span> Transaction Logs</a></li>
                    </ul>
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <a href="/Newram/logout.php">
                        <span class="fa fa-sign-out-alt"></span> Logout
                    </a>
                </li>
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

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#" onclick="loadContent('home.php');">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Portfolio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>