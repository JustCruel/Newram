<?php
if (isset($_SESSION['firstname']) && isset($_SESSION['lastname'])) {
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
} else {
    // Handle case where session variables are not set
    $firstname = 'Guest';
    $lastname = '';
}

// Get the current page's filename
$currentPage = basename($_SERVER['PHP_SELF']);
?>




<!-- Top Bar -->
<div class="top-bar">
    <h4>Ramstar</h4>
    <div class="profile">
        <i class="fas fa-user-circle fa-2x"></i>
        <span>Admin</span>
        <a href="../logout.php" class="btn btn-sm btn-light">Logout</a>
    </div>
</div>

<!-- Sidebar -->
<nav class="sidebar">
    <h4>Admin Panel</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'admindashboard.php') ? 'active' : ''; ?>"
                href="admindashboard.php">
                <i class="fa fa-home"></i> Dashboard
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'register.php') ? 'active' : ''; ?>" href="register.php">
                <i class="fa fa-user"></i> Registration
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'regemploye.php') ? 'active' : ''; ?>" href="regemploye.php">
                <i class="fa fa-user"></i> Reg Employee
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle <?php echo ($currentPage == 'activate.php' || $currentPage == 'manageaccounts.php' || $currentPage == 'accountsettings.php') ? 'active' : ''; ?>" 
       href="#" 
       id="accountsDropdown" 
       role="button" 
       data-bs-toggle="dropdown" 
       aria-expanded="false">
        <i class="fa fa-sticky-note"></i> Accounts
    </a>
    <ul class="dropdown-menu" aria-labelledby="accountsDropdown">
        <li>
            <a class="dropdown-item <?php echo ($currentPage == 'activate_users.php') ? 'active' : ''; ?>" href="activate_users.php">Activate Accounts</a>
        </li>
        <li>
            <a class="dropdown-item <?php echo ($currentPage == 'disable_users.php') ? 'active' : ''; ?>" href="disable_users.php">Disable Accounts</a>
        </li>
        <li>
            <a class="dropdown-item <?php echo ($currentPage == 'transfer_user_funds.php') ? 'active' : ''; ?>" href="transfer_user_funds.php">Transfer User Funds</a>
        </li>
    </ul>
</li>


        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'revenue.php') ? 'active' : ''; ?>" href="revenue.php">
                <i class="fa fa-cogs"></i> Revenue
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'fareupdate.php') ? 'active' : ''; ?>" href="fareupdate.php">
                <i class="fa fa-arrow-up-1-9"></i> Fare Update
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'businfo.php') ? 'active' : ''; ?>" href="businfo.php">
                <i class="fa fa-bus"></i> Reg Bus Info
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'busviewinfo.php') ? 'active' : ''; ?>"
                href="busviewinfo.php">
                <i class="fa fa-eye"></i> View Bus Info
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'feedbackview.php') ? 'active' : ''; ?>"
                href="feedbackview.php">
                <i class="fa fa-eye"></i> Feedbacks
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link" href="../logout.php">
                <i class="fa fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</nav>


<!-- Hamburger Button -->
<i id="hamburger" class="fas fa-bars fa-2x"></i>
<!-- Footer -->
<footer class="footer">
    <p>&copy; <?php echo date('Y'); ?> Ramstar Bus. All rights reserved.</p>
 
    <div class="footer-links">
        <a href="../terms.php" target="_blank">Terms and Conditions</a> | 
        <a href="../privacy.php" target="_blank">Privacy Policy</a>
    </div>
</footer>

