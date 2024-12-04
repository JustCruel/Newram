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
                <a href="./index.php"><span class="fa fa-tachometer-alt"></span>
                    Dashboard</a>
            </li>
            <li>
                <a href="./loadrfid.php"><span class="fa fa-credit-card"></span>
                    Load RFID</a>
            </li>
            <li>
                <a href="./activate.php"><span class="fa fa-bolt"></span>
                    Activation</a>
            </li>
            <li>
                <a href="./transactionlogs.php"><span class="fa fa-list-alt"></span>
                    Load Transaction</a>
            </li>
            <li>
                <a href="./loadtransaction.php"><span class="fa fa-chart-line"></span>
                    Load Revenue</a>
            </li>
            <li>
                <a href="../logout.php"><span class="fa fa-sign-out-alt"></span> Logout</a>
            </li>
        </ul>

    </nav>