<?php
session_start();
ob_start();
include 'config/connection.php';
$errors = array();
$msg = "";

if (isset($_POST['Login'])) {
   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $password = mysqli_real_escape_string($conn, md5($_POST['password']));

   // Normalize contact number: if it starts with +63, replace with 0
   if (strpos($username, '+63') === 0) {
      $username = '0' . substr($username, 3);
   }

   // Check for empty inputs
   if (empty($username)) {
      array_push($errors, "<h4 style='background-color:tomato; text-align:center; color:#FFFFFF;'>Username is required!</h4>");
   }
   if (empty($password)) {
      array_push($errors, "<h4 style='background-color:tomato; text-align:center; color:#FFFFFF;'>Password is required!</h4>");
   }

   // Updated query to check for email, account_number, or normalized contact number, and is_activated status
   $check_user_query = "SELECT * FROM users1 WHERE (email='{$username}' OR account_number='{$username}') AND password='{$password}'";
   $check_user = mysqli_query($conn, $check_user_query);

   // Check for SQL errors
   if (!$check_user) {
      die("Database query failed: " . mysqli_error($conn));
   }

   if (mysqli_num_rows($check_user) > 0) {
      $row = mysqli_fetch_assoc($check_user);

      // Check if the account is activated
      if ($row['is_activated'] == 0) {
         $msg = "<div class='alert alert-warning' style='background-color:#FFA500; text-align:center; color:#FFFFFF;'>Your account is not activated! Please contact support.</div>";
      } else {
         // Set session variables if activated
         $_SESSION['id'] = $row['id'];
         $_SESSION['firstname'] = $row['firstname'];
         $_SESSION['lastname'] = $row['lastname'];
         $_SESSION['middlename'] = $row['middlename'];
         $_SESSION['gender'] = $row['gender'];
         $_SESSION['age'] = $row['age'];
         $_SESSION['birthday'] = $row['birthday'];
         $_SESSION['email'] = $row['email'];
         $_SESSION['account_number'] = $row['account_number'];
         $_SESSION['contactnumber'] = $row['contactnumber'];
         $_SESSION['address'] = $row['address'];
         $_SESSION['role'] = $row['role']; // Store role in session

         // Use JavaScript to show an alert and then redirect
         echo "
         <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
         <script>
        window.onload = function() {
            Swal.fire({
                icon: 'success',
                title: 'Successfully logged in!',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                // Redirect based on user role
                var baseUrl = '{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/newram/';
            if ('{$row['role']}' === 'Admin') {
                window.location.href = baseUrl + 'admin/index.php';
            } else if ('{$row['role']}' === 'Cashier') {
                window.location.href = baseUrl + 'cashier/index.php';
            } else if ('{$row['role']}' === 'User') {
                window.location.href = baseUrl + 'users/index.php';
            }
            });
        };
    </script>
         ";
         exit;
      }
   } else {
      $msg = "<div class='alert alert-danger' style='background-color:#BF0210; text-align:center; color:#FFFFFF;'>Invalid Credentials!</div>";
   }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
   <meta charset="utf-8">
   <title>Login</title>
   <link rel="stylesheet" href="css/login.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <style>
      body {
         background: White;
      }

      .field {
         position: relative;
      }

      .field i {
         position: absolute;
         right: 10px;
         top: 50%;
         transform: translateY(-50%);
         cursor: pointer;
      }
   </style>
   <script type="text/javascript">
      function togglePassword(inputId, iconId) {
         var input = document.getElementById(inputId);
         var icon = document.getElementById(iconId);
         if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
         } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
         }
      }

      function goBack() {
         window.history.back();
      }
   </script>
</head>

<header>
   <nav>
      <ul>
         <li><a href="Home.php" target="_self" class="aheader">Home</a></li>
      </ul>
   </nav>
</header>

<body><br><br>
   <div class="wrapper">
      <p>Login Form</p>
      <div class="title-text">
         <div class="title login"></div>
      </div>
      <div class="form-container">
         <br>
         <div class="form-inner">
            <form method="POST" action="#" class="login">
               <?php echo $msg; ?>
               <div class="field">
                  <input type="text" name="username" placeholder="Account Number/Email" required>
               </div>
               <div class="field">
                  <input type="password" name="password" placeholder="Password" id="pass2" required>
                  <i class="fas fa-eye" id="togglePassword2" onclick="togglePassword('pass2', 'togglePassword2')"></i>
               </div>
               <div class="field btn">
                  <div class="btn-layer"></div>
                  <input type="submit" name="Login" value="Log in">
               </div>

               <div class="signup-link">
                  <button type="button" onclick="goBack()"
                     style="background-color: rgb(87, 107, 237); border: none; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 4px;">
                     Go Back
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>
</body>

</html>