<?php
session_start();
ob_start();
include 'config/connection.php';

$errors = [];
$msg = "";

// Helper function to get redirect URL based on role
function getRedirectURL($role)
{
   switch ($role) {
      case 'Admin':
         return 'admin/admindashboard.php';
      case 'Cashier':
         return 'cashier/cashierdashboard.php';
      case 'Superadmin':
         return 'superadmin/superadmin.php';
      case 'User':
         return 'users/index.php';
      case 'Conductor':
         return 'conductor/conductordashboard.php';
      default:
         return 'index.php';
   }
}

if (isset($_POST['Login'])) {
   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $password = mysqli_real_escape_string($conn, md5($_POST['password']));

   // Normalize contact number: if it starts with +63, replace with 0
   if (strpos($username, '+63') === 0) {
      $username = '0' . substr($username, 3);
   }

   // Validate inputs
   if (empty($username)) {
      $errors[] = "Username is required!";
   }
   if (empty($password)) {
      $errors[] = "Password is required!";
   }

   if (empty($errors)) {
      // Query to check user credentials
      $check_user_query = "
            SELECT * 
            FROM useracc 
            WHERE (email = '{$username}' OR account_number = '{$username}') 
            AND password = '{$password}'";

      $check_user = mysqli_query($conn, $check_user_query);

      if (!$check_user) {
         die("Database query failed: " . mysqli_error($conn));
      }

      if (mysqli_num_rows($check_user) > 0) {
         $row = mysqli_fetch_assoc($check_user);

         if ($row['is_activated'] == 0) {
            $msg = "<div class='alert alert-warning' style='background-color:#FFA500; text-align:center; color:#FFFFFF;'>Your account is not activated! Please contact support.</div>";
         } else {
            // Set session variables
            foreach ($row as $key => $value) {
               $_SESSION[$key] = $value;
            }

            // Trigger SweetAlert2 for successful login using JavaScript
            echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Swal.fire({
                            title: 'Login Successfully',
                            text: ' " . /* htmlspecialchars($row['fullname']) . */ "',
                            icon: 'success',
                            confirmButtonText: 'Continue'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '" . getRedirectURL($row['role']) . "';
                            }
                        });
                    });
                    </script>";
            exit;
         }
      } else {
         $msg = "<div class='alert alert-danger' style='background-color:#BF0210; text-align:center; color:#FFFFFF;'>Invalid Credentials!</div>";
      }
   } else {
      foreach ($errors as $error) {
         $msg .= "<div class='alert alert-danger' style='background-color:#BF0210; text-align:center; color:#FFFFFF;'>{$error}</div>";
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <link rel="stylesheet" href="css/login.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <style>
      body {
         background: #f0f2f5;
         font-family: Arial, sans-serif;
      }

      .wrapper {
         max-width: 400px;
         margin: 0 auto;
         padding: 40px;
         background-color: #fff;
         border-radius: 8px;
         box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      }

      .title-text {
         text-align: center;
         margin-bottom: 30px;
      }

      .title-text p {
         font-size: 24px;
         font-weight: bold;
      }

      .form-container {
         margin-top: 10px;
      }

      .field {
         margin-bottom: 20px;
         position: relative;
      }

      .field input {
         width: 100%;
         padding: 10px;
         font-size: 16px;
         border: 1px solid #ccc;
         border-radius: 4px;
         background-color: #f9f9f9;
      }

      .field i {
         position: absolute;
         right: 10px;
         top: 50%;
         transform: translateY(-50%);
         cursor: pointer;
      }

      .field input:focus {
         outline: none;
         border-color: #3498db;
      }

      .btn {
         width: 100%;
         padding: 15px;
         background-color: #576BED;
         color: white;
         font-size: 18px;
         border: none;
         border-radius: 4px;
         cursor: pointer;
         transition: background-color 0.3s;
      }

      .btn:hover {
         background-color: #2980b9;
      }

      .alert {
         text-align: center;
         padding: 10px;
         border-radius: 5px;
         margin-bottom: 20px;
         font-size: 14px;
      }

      .alert-warning {
         background-color: #FFA500;
         color: white;
      }

      .alert-danger {
         background-color: #BF0210;
         color: white;
      }

      header {
         background-color: #576BED;
         color: white;
         padding: 15px;
      }

      header nav ul {
         list-style: none;
         text-align: center;
      }

      header nav ul li {
         display: inline;
         margin: 0 10px;
      }

      header nav ul li a {
         color: white;
         font-size: 16px;
         font-weight: bold;
         text-decoration: none;
         transition: color 0.3s;
      }

      header nav ul li a:hover {
         color: #2980b9;
      }
   </style>
   <script>
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
   </script>
</head>

<body>
   <header>
      <nav>
         <ul>
            <li><a href="index.php">Home</a></li>
         </ul>
      </nav>
   </header>

   <div class="wrapper">
      <p>Login Form</p>
      <div class="form-container">
         <form method="POST" action="#" class="login">
            <?php echo $msg; ?>
            <div class="field">
               <input type="text" name="username" placeholder="Account Number/Email" required>
            </div>
            <div class="field">
               <input type="password" name="password" placeholder="Password" id="pass2" required>
               <i class="fas fa-eye" id="togglePassword2" onclick="togglePassword('pass2', 'togglePassword2')"></i>
            </div>
            <input type="submit" name="Login" value="Log in" class="btn">
         </form>
      </div>
   </div>
</body>

</html>