<div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar" class="active">
        <h1><a href="index.php" class="logo">Ramstar</a></h1>
        <ul class="list-unstyled components mb-5">
            <li class="active">
                <a href="./index.php"><span class="fa fa-home"></span>
                    Dashboard</a>
            </li>
            <li>
                <a href="#register" onclick="loadContent('loadrfid.php');"><span class="fa fa-user"></span>
                    Load RFID</a>
            </li>
            <li>
                <a href="#deactivation" onclick="loadContent('activate.php');"><span class="fa fa-sticky-note"></span>
                    Activation</a>
            </li>
            <li>
                <a href="#revenue" onclick="loadContent('revenue.php');"><span class="fa fa-cogs"></span>
                    Revenue</a>
            </li>
            <li>
                <a href="../logout.php"><span class="fa fa-paper-plane"></span> Logout</a>
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