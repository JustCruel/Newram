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
   $check_user_query = "SELECT * FROM useracc WHERE (email='{$username}' OR account_number='{$username}') AND password='{$password}'";
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

         // Redirect based on user role
         if ($row['role'] === 'Admin') {
            echo "<script>window.location.href = 'admin/index.php';</script>";
         } else if ($row['role'] === 'Cashier') {
            echo "<script>window.location.href = 'cashier/index.php';</script>";
         } else if ($row['role'] === 'Superadmin') {
            echo "<script>window.location.href = 'superadmin/index.php';</script>";
         } else if ($row['role'] === 'User') {
            echo "<script>window.location.href = 'users/index.php';</script>";
         } else if ($row['role'] === 'Conductor') {
            // Fetch available buses for the conductor to select
            $bus_query = "SELECT bus_number FROM businfo WHERE status = 'available'";
            $bus_result = mysqli_query($conn, $bus_query);

            // Prepare options for SweetAlert
            $bus_options = "";
            while ($bus = mysqli_fetch_assoc($bus_result)) {
               $bus_options .= "<option value=\"" . $bus['bus_number'] . "\">" . $bus['bus_number'] . "</option>";
            }

            // Show bus selection form for conductor
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
            window.onload = function() {
                // Step 1: Select Bus
                Swal.fire({
                    icon: 'question',
                    title: 'Select Bus',
                    html: '<form id=\"busForm\" method=\"POST\" action=\"select_bus.php\">' +
                          '<select name=\"bus_number\" id=\"bus_number\" required style=\"' + 
                          'width: 100%;' +
                          'padding: 10px;' +
                          'border: 2px solid #ddd;' +
                          'border-radius: 5px;' +
                          'font-size: 16px;' +
                          'box-sizing: border-box;' +
                          'background-color: #f9f9f9;' +
                          '\" class=\"swal2-input\">' + 
                          '" . $bus_options . "' +
                          '</select><br><br>' +
                          '</form>',
                    showCancelButton: false,
                    confirmButtonText: 'Next',
                    preConfirm: function() {
                        return new Promise((resolve) => {
                            const selectedBus = document.getElementById('bus_number').value;
                            if (selectedBus) {
                                resolve(selectedBus);
                            } else {
                                Swal.showValidationMessage('Please select a bus');
                            }
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const busNumber = result.value;
            
                        // Step 2: Enter Driver Name
                        Swal.fire({
                            icon: 'question',
                            title: 'Enter Driver Name',
                            input: 'text',
                            inputPlaceholder: 'Driver Name',
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            preConfirm: (driverName) => {
                                if (!driverName) {
                                    Swal.showValidationMessage('Driver name is required');
                                }
                                return { busNumber, driverName };
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const { busNumber, driverName } = result.value;
            
                                // Submit form with bus number and driver name
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = 'select_bus.php';
            
                                const busInput = document.createElement('input');
                                busInput.type = 'hidden';
                                busInput.name = 'bus_number';
                                busInput.value = busNumber;
            
                                const driverInput = document.createElement('input');
                                driverInput.type = 'hidden';
                                driverInput.name = 'driver_name';
                                driverInput.value = driverName;
            
                                form.appendChild(busInput);
                                form.appendChild(driverInput);
            
                                document.body.appendChild(form);
                                form.submit();
                            }
                        });
                    }
                });
            };
            </script>";
         }

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


            </form>
         </div>
      </div>
   </div>
</body>

</html>