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
        <span>Cashier</span>
        <a href="logout.php" class="btn btn-sm btn-light">Logout</a>
    </div>
</div>

<!-- Sidebar -->
<nav class="sidebar">
    <h4>Cashier Panel</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'cashierdashboard.php') ? 'active' : ''; ?>"
                href="cashierdashboard.php">
                <i class="fa fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'loadrfidadmin.php') ? 'active' : ''; ?>"
                href="loadrfidadmin.php">
                <i class="fa fa-credit-card"></></i> Load RFID
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'remit.php') ? 'active' : ''; ?>" href="remit.php">
                <i class="fa fa-chart-line me-2"></i>Remit
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'translogscashier.php') ? 'active' : ''; ?>"
                href="translogscashier.php">
                <i class="fa fa-list-alt me-2"></i> Load Transaction
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'remit_logs.php') ? 'active' : ''; ?>" href="remit_logs.php">
                <i class="fa fa-list-alt me-2"></i> Remit Logs
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'loadtranscashier.php') ? 'active' : ''; ?>"
                href="loadtranscashier.php">
                <i class="fa fa-chart-line me-2"></i> Load Revenue
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

<footer class="footer">
    <p>&copy; <?php echo date('Y'); ?> Ramstar Bus. All rights reserved.</p>
 
    <div class="footer-links">
        <a href="../terms.php" target="_blank">Terms and Conditions</a> | 
        <a href="../privacy.php" target="_blank">Privacy Policy</a>
    </div>
</footer>