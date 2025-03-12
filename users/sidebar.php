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



<!-- Top Bar -->
<div class="top-bar">
    <h4>Ramstar</h4>
    <div class="profile">
        <i class="fas fa-user-circle fa-2x"></i>
        <span>User</span>
        <a href="../logout.php" class="btn btn-sm btn-light">Logout</a>
    </div>
</div>

<!-- Sidebar -->
<nav class="sidebar">
    <h4>User Panel</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>" href="index.php">
                <i class="fa fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'recent_trips.php') ? 'active' : ''; ?>"
                href="recent_trips.php">
                <i class="fa fa-id-card me-2"></i> Recent Trips
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'convert_points.php') ? 'active' : ''; ?>"
                href="convert_points.php">
                <i class="fa fa-coins me-2"></i>Convert Points
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'updatepass.php') ? 'active' : ''; ?>" href="updatepass.php">
                <i class="fa fa-file-alt me-2"></i>Update Password
            </a>
        </li>
        <div class="sidebar-divider"></div>
        <li class="nav-item">
            <a class="nav-link <?php echo ($currentPage == 'transactionlogs.php') ? 'active' : ''; ?>"
                href="transactionlogs.php">
                <i class="fa fa-paper-plane me-2"></i> Transaction Logs
            </a>
        </li>

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