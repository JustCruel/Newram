<?php
include 'config/connection.php';
$errors = array();
$username = "";
$firstname = "";
$lastname = "";
$middlename = "";
$birthday = "";
$age = "";
$gender = "";
$email = "";
$password = "";
$passwordconfirm = "";
$add2 = "";


// Fetch states from the database
$sqlStates = "SELECT * FROM provincestate";
$resultStates = mysqli_query($conn, $sqlStates);

?>



<!DOCTYPE html>
<html lang="en">


<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" type="text/css" href="Registerstyle.css">
<title>Commuter Registration</title>
<meta charset="UTF-8">

<style>
  body {
    font-family: Arial, sans-serif;
    background-color: LightGray;
  }

  .dashboard-item {
    background-color: rgb(87 107 237);
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin: 20px;
  }

  .dashboard-item h3 {
    margin-bottom: 30px;
    color: #4caf50;
  }

  .dashboard-item p {
    font-size: 20px;
    color: #333;
  }

  .dashboard {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
  }



  .dashboard-item i {
    font-size: 40px;
    margin-bottom: 20px;
  }
</style>
</head>
<script type="text/javascript">
  window.addEventListener("scroll", function () {
    var header = document.querySelector("header");
    header.classList.toggle("sticky", window.scrollY > 0);
  })
</script>
<script type="text/javascript">
  function myFunction1() {
    var x = document.getElementById("pass1");
    var y = document.getElementById("pass2");
    if (x.type === "password" || y.type === "password") {
      x.type = "text";
      y.type = "text";
    } else {
      x.type = "password";
      y.type = "password";
    }
  }
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Google Maps JavaScript library -->
<script
  src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCdGv5cjpA0dMUCSolCf89tl_vgccGvsu0"></script>

<?php
if (isset($_POST['submit'])) {
  // Insert user details
  $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
  $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
  $middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
  $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
  $age = mysqli_real_escape_string($conn, $_POST['age']);
  $gender = mysqli_real_escape_string($conn, $_POST['gender']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $province = mysqli_real_escape_string($conn, $_POST['province']);
  $city = mysqli_real_escape_string($conn, $_POST['city']);
  $brgy = mysqli_real_escape_string($conn, $_POST['barangay']);
  $home_number = mysqli_real_escape_string($conn, $_POST['hs']);
  $contact = mysqli_real_escape_string($conn, $_POST['contact']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $passwordconfirm = mysqli_real_escape_string($conn, $_POST['passwordconfirm']);

  // Age validation
  if ($age <= 7) {
    array_push($errors, "<h4 style='background-color:tomato; text-align:center;'> Age should be 15 and above!</h4>");
  }

  // Address validation
  if ($province == "" || $city == "" || $brgy == "") {
    array_push($errors, "<h4 style='background-color:tomato; text-align:center;'>Please Input Province, Municipality/City, and Barangay!</h4>");
  } else {
    // Fetch province, city, and barangay from database
    $selectprovince = "SELECT * FROM provincestate WHERE province_id='$province'";
    $resultprovince = mysqli_query($conn, $selectprovince);
    $provinceselected = mysqli_fetch_assoc($resultprovince);

    $selectcity = "SELECT * FROM municipalities WHERE municipality_id='$city'";
    $resultcity = mysqli_query($conn, $selectcity);
    $cityselected = mysqli_fetch_assoc($resultcity);

    $selectbrgy = "SELECT * FROM barangay WHERE barangay_id='$brgy'";
    $resultbrgy = mysqli_query($conn, $selectbrgy);
    $brgyselected = mysqli_fetch_assoc($resultbrgy);

    // Construct the complete address
    $address = $home_number . ", " . $brgyselected['barangay'] . ", " . $cityselected['municipality'] . ", " . $provinceselected['provincestate'];
  }

  // Email validation
  $user_check_query = "SELECT * FROM users WHERE email='$email'";
  $result = mysqli_query($conn, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) {
    if ($user['email'] === $email) {
      array_push($errors, "<h4 style='background-color:tomato; text-align:center;'>E-mail already exists!</h4>");
    }
  }

  // Password validation
  if ($password != $passwordconfirm) {
    array_push($errors, "<h4 style='background-color:tomato; text-align:center;'>Password does not match!</h4>");
  }

  $uppercase = preg_match('@[A-Z]@', $password);
  $lowercase = preg_match('@[a-z]@', $password);
  $number = preg_match('@[0-9]@', $password);
  $specialChars = preg_match('@[\W_]@', $password);
  if (!$specialChars || !$uppercase || !$lowercase || !$number || strlen($password) < 8) {
    array_push($errors, "<h4 style='background-color:tomato; text-align:center;'>Password should be at least 8 characters and include 1 uppercase letter, 1 lowercase letter, 1 number, and 1 symbol!</h4>");
  }

  if (count($errors) == 0) {
    $password = md5($passwordconfirm); // Encrypt password

    // Insert user details into database
    $sql = "INSERT INTO users (firstname, lastname, middlename, birthday, age, gender, email, contactnumber, address, password)
                VALUES ('$firstname', '$lastname', '$middlename', '$birthday', '$age', '$gender', '$email', '$contact', '$address', '$password')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      echo "<script>alert('You have successfully registered!'); window.location='Registration.php'</script>";
    }
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RAMSTAR</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/styles.css"> <!-- Your custom CSS -->
  <style>
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      background-color: #f0f0f0;
      display: flex;
      height: 100vh;
    }

    .sidebar {
      width: 250px;
      background-color: #ffffff;
      padding: 20px;
      color: #001f3f;
      transition: width 0.3s ease;
      display: flex;
      flex-direction: column;
      height: 100vh;
      border-right: 1px solid #e0e0e0;
      /* Added border for sidebar */
    }

    .sidebar img {
      width: 100%;
      /* Make logo responsive */
      height: auto;
      margin-bottom: 20px;
    }

    .button-card {
      display: flex;
      align-items: center;
      background-color: #007bff;
      color: white;
      border-radius: 8px;
      padding: 15px;
      margin: 10px 0;
      text-decoration: none;
      transition: background-color 0.3s ease;
      cursor: pointer;
    }

    .button-card:hover {
      background-color: yellow;
    }

    .main-content {
      flex: 1;
      margin: 0;
      padding: 20px;
      overflow-y: auto;
      background-color: #ffffff;
      border-left: 1px solid #e0e0e0;
    }

    h2 {
      margin-bottom: 20px;
      font-size: 24px;
      /* Increased font size for better visibility */
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .sidebar {
        width: 200px;
      }

      .main-content {
        padding: 15px;
      }

      h2 {
        font-size: 20px;
        /* Smaller heading on smaller screens */
      }
    }

    @media (max-width: 576px) {
      .sidebar {
        width: 150px;
      }

      h2 {
        font-size: 18px;
      }
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <img src="images/logoramstar.jpg" alt="Holy Cross College Logo"> <!-- Logo -->
    <h2>Menu</h2>

    <a class="button-card" href="Dashboardadmin.php">
      <i class="fas fa-tachometer-alt"></i> Home
    </a>
    <a class="button-card" href="Registration.php">
      <i class="fas fa-user"></i> Registration
    </a>
    <a class="button-card" href="userload.php">
      <i class="fas fa-wallet"></i> Load User
    </a>

    <a class="button-card" href="users.php">
      <i class="fas fa-info-circle"></i> View Registered Users
    </a>
    <a class="button-card" href="Revenue.php">
      <i class="fas fa-info-circle"></i> Revenue

      <a class="button-card" href="Logout.php">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
  </div>



  <script>
    function showContent(page) {
      const mainContent = document.getElementById('main-content');
      fetch(page)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.text();
        })
        .then(data => {
          mainContent.innerHTML = data; // Inject the content here
        })
        .catch(error => {
          mainContent.innerHTML = `<h1>Error loading page</h1><p>${error.message}</p>`;
        });
    }
  </script>
</body>

</html>


<body><br><br><br><br>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#state').change(function () {
        var stateId = $(this).val();
        if (stateId) {
          $.ajax({
            type: 'POST',
            url: 'fetch_municipalities.php',
            data: 'state_id=' + stateId,
            success: function (html) {
              $('#city').html(html);
              $('#street').html('<option value="">Select Barangay</option>');
            }
          });
        } else {
          $('#city').html('<option value="">Select Municipality</option>');
          $('#street').html('<option value="">Select Barangay</option>');
        }
      });

      $('#city').change(function () {
        var cityId = $(this).val();
        if (cityId) {
          $.ajax({
            type: 'POST',
            url: 'fetch_barangays.php',
            data: 'city_id=' + cityId,
            success: function (html) {
              $('#street').html(html);
            }
          });
        } else {
          $('#street').html('<option value="">Select Barangay</option>');
        }
      });
    });
  </script>
  <div class="container">
    <div class="sidebar">
      <nav class="sidenav" id="mySidenav">

        <a href="Dashboardadmin.php">Home</a>
        <a href="Registration.php">Registration</a>
        <a href="userload.php">Load User</a>
        <a href="users.php">View Registered Users</a>
        <a href="Revenue.php">Revenue</a>
        <a href="audit.php" class="text-white">Audit Records</a>
        <a href="Logout.php">Logout</a>
      </nav>
    </div>
    <div class="title">Commuter Registration</div>
    <!---start of modal--->
    <div class="center">
      <input type="checkbox" id="click">
      <label for="click" class="click-me">How to create account?</label>
      <div class="content">
        <div class="header">
          <h2>How to create account?</h2>
          <label for="click" class="fas fa-times"></label>
        </div>
        <label for="click" class="fas fa-check"></label>
        <br>It may contain uppercase and lowercase letters, numbers, underscore, space and dash.
        <br>Avoid using indistinguishable username to your account. <br> e.g Pogi-Ako12</p>
        <p>E-mail should have proper extensions. <br> e.g example@gmail.com </p>
        <p>It is recommended to have a strong password. <br> A strong password may contain letters, numbers and
          symbols.
          <br> Avoid using birthdays and Valid ID numbers as your password.
        </p>
        <div class="line"></div>
        <label for="click" class="close-btn">Close</label>
      </div>
    </div>
    <!--end of modal-->
    <div class="contents">
      <form action="" method="POST">
        <?php include('config/errors.php'); ?>
        <div class="user-details">

          <div class="input-box">
            <label class="details">First Name <span style="color: red;">*</span></label>
            <input type="text" placeholder="First Name" id="firstname" name="firstname"
              value="<?php echo $firstname; ?>" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" required>
          </div>
          <div class="input-box">
            <label class="details">Last Name <span style="color: red;">*</span></label>
            <input type="text" placeholder="Last Name" id="lastname" name="lastname" value="<?php echo $lastname; ?>"
              oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" required>
          </div>
          <div class="input-box">
            <label class="details">Middle Name</label>
            <input type="text" placeholder="Middle Name (Optional)" id="middlename" name="middlename"
              value="<?php echo $middlename; ?>" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
          </div>
          <div class="input-box">
            <span class="details">Birthday <span style="color: red;">*</span></span>
            <input type="date" placeholder="Birthday" class="birthday" onchange="calculateAge()"
              oninput="calculateAge()" id="birthday" name="birthday" value="<?php echo $birthday; ?>" max="2017-12-31"
              required>
          </div>
          <div class="input-box">
            <span class="details">Age <span style="color: red;">*</span></span>
            <input type="number" class="age" placeholder="Age" id="age" name="age" value="<?php echo $age; ?>" readonly>
          </div>
          <div class="mb-3">
            <label class="details">Gender <span style="color: red;">*</span></label>
            <div>
              <span class="details">
                <input type="radio" name="gender" value="Male" required> Male
              </span><br>
              <span class="details">
                <input type="radio" name="gender" value="Female" required> Female
              </span>
            </div>
            <br>
            <div class="input-box">
              <span class="details">Province <span style="color: red;">*</span></span>
              <select id="state" name="province" onchange="fetchMunicipalities(this.value)">
                <option value="">Select Province/State</option>
                <?php while ($row = mysqli_fetch_assoc($resultStates)) { ?>
                  <option value="<?php echo $row['province_id']; ?>"><?php echo $row['provincestate']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="input-box">
              <span class="details">Municipality/City <span style="color: red;">*</span></span>
              <select id="city" name="city" onchange="fetchBarangays(this.value)">
                <option value="">Select Municipality</option>
              </select>
            </div>
            <div class="input-box">
              <span class="details">Barangay <span style="color: red;">*</span></span><br>
              <select id="street" name="barangay">
                <option value="">Select Barangay</option>
              </select>
            </div>
            <div class="input-box">
              <span class="details">House Number / Street Name / Lot No.</span>
              <input type="text" id="textInput2" placeholder="House Number / Street Name / Lot No. (Optional)" name="hs"
                value="<?php echo $add2; ?>" required>
            </div>
            <div class="input-box">
              <span class="details">Contact No. <span style="color: red;">*</span></span>
              <input type="text" id="textInput3" placeholder="Contact Number" name="contact" value="+63"
                oninput="formatInput(this);">
            </div>
            <div class="input-box">
              <span class="details">E-mail <span style="color: red;">*</span></span>
              <input type="email" placeholder="E-mail" name="email" id="Email" value="<?php echo $email; ?>" required>
            </div>
            <label for="password" class="hidden-label">Commuters Password</label>
            <div class="mb-3">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>




            <p style="font-size: 12px; color: black;">By clicking 'Register', you agree to use the data above as
              information
              for future submission of a inquiry form, requesting a document or filing a complaint.
              In accordance to Data Privacy Act of 2012 (RA 10173), we asure you to keep the data confidential and will
              not
              be used in any unrelated and insignificant transactions. </p>
            <div class="button">
              <input type="submit" value="Register" name="submit" id="submit"
                onclick="alert('You are about to submit this form')" formtarget="_self">
            </div>
      </form>
      <div style="text-align: center;">
        <button onclick="goBack()" style="background-color: rgb(87 107 237);
                                       border: none;
                                       color: white;
                                       padding: 10px 20px; 
                                       text-align: center;
                                       text-decoration: none;
                                       display: inline-block;
                                       font-size: 16px;
                                       margin: 4px 2px;
                                       cursor: pointer;
                                       border-radius: 4px;">Go Back</button>
      </div>

      <script>

        function calculateAge() {
          // Get the input value of the birthday
          var birthday = document.getElementById('birthday').value;

          // Calculate the age
          var today = new Date();
          var birthDate = new Date(birthday);
          var age = today.getFullYear() - birthDate.getFullYear();
          var month = today.getMonth() - birthDate.getMonth();
          if (month < 0 || (month === 0 && today.getDate() < birthDate.getDate())) {
            age--;
          }

          // Set the calculated age to the input field
          document.getElementById('age').value = age;
        }


        function goBack() {
          window.history.back();
        }
      </script>
      <script type="text/javascript">

        document.getElementById("textInput").addEventListener("input", function () {
          var inputText = this.value;
          if (inputText.length > 0) {
            // Send AJAX request to fetch suggestions
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "fetch_provinces.php");
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
              if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                  // Parse JSON response and update dropdown list
                  var suggestions = JSON.parse(xhr.responseText);
                  var dropdown = document.getElementById("suggestionDropdown");
                  dropdown.innerHTML = "";
                  suggestions.forEach(function (suggestion) {
                    var option = document.createElement("div");
                    option.textContent = suggestion;
                    option.addEventListener("click", function () {
                      document.getElementById("textInput").value = suggestion;
                      dropdown.innerHTML = "";
                    });
                    dropdown.appendChild(option);
                  });
                } else {
                  console.error("Error fetching suggestions");
                }
              }
            };
            xhr.send("input=" + encodeURIComponent(inputText));
          } else {
            // Clear dropdown if input is empty
            document.getElementById("suggestionDropdown").innerHTML = "";
          }
        });

        document.addEventListener("DOMContentLoaded", function () {
          var emailInput = document.getElementById("Email");
          var firstnameInput = document.getElementById("firstname");
          var lastnameInput = document.getElementById("lastname");
          var textInput = document.getElementById("textInput");
          var textInput2 = document.getElementById("textInput2");
          var textInput3 = document.getElementById("textInput3");

          emailInput.addEventListener("focus", function () {
            document.getElementById("emailRequired").style.display = "inline";
          });

          emailInput.addEventListener("blur", function () {
            document.getElementById("emailRequired").style.display = "none";
          });
          firstnameInput.addEventListener("focus", function () {
            document.getElementById("firstnameRequired").style.display = "inline";
          });

          firstnameInput.addEventListener("blur", function () {
            document.getElementById("firstnameRequired").style.display = "none";
          });
          lastnameInput.addEventListener("focus", function () {
            document.getElementById("lastnameRequired").style.display = "inline";
          });

          lastnameInput.addEventListener("blur", function () {
            document.getElementById("lastnameRequired").style.display = "none";
          });

          textInput.addEventListener("focus", function () {
            document.getElementById("addressRequired").style.display = "inline";
          });

          textInput.addEventListener("blur", function () {
            document.getElementById("addressRequired").style.display = "none";
          });
          textInput2.addEventListener("focus", function () {
            document.getElementById("text2Required").style.display = "inline";
          });

          textInput2.addEventListener("blur", function () {
            document.getElementById("text2Required").style.display = "none";
          });
          textInput3.addEventListener("focus", function () {
            document.getElementById("text3Required").style.display = "inline";
          });

          textInput3.addEventListener("blur", function () {
            document.getElementById("text3Required").style.display = "none";
          });
          // Add similar event listeners for other input fields
        });

        document.addEventListener("DOMContentLoaded", function () {
          var genderRequired = document.getElementById("genderRequired");
          genderRequired.style.display = "none"; // Hide terms required text initially
          var checkbox2 = document.getElementById("checkbox2");
          var checkbox1 = document.getElementById("checkbox1");

          checkbox1.addEventListener("change", function () {
            if (checkbox1.checked) {
              genderRequired.style.display = "none";
            } else {
              genderRequired.style.display = "inline";
            }
          });
          checkbox2.addEventListener("change", function () {
            if (checkbox2.checked) {
              genderRequired.style.display = "none";
            } else {
              genderRequired.style.display = "inline";
            }
          });
        });

        <script>
          $(document).ready(function(){
            // When a state is selected
            $('#state').change(function () {
              var stateId = $(this).val();
              // AJAX call to fetch cities based on the selected state
              $.ajax({
                url: 'fetch_municipality.php', // PHP script to fetch cities
                method: 'POST',
                data: { state_id: stateId },
                success: function (response) {
                  $('#city').html(response);
                }
              });
            });

          // When a city is selected
          $('#city').change(function(){
            var cityId = $(this).val();
          // AJAX call to fetch streets based on the selected city
          $.ajax({
            url: 'fetch_barangay.php', // PHP script to fetch streets
          method: 'POST',
          data: {city_id: cityId},
          success: function(response){
            $('#street').html(response);
                }
            });
        });
    });
      </script>


      </script>
      <script>
          function validateDate() {
    var birthdayInput = document.getElementById("birthday");
          var birthdayRequired = document.getElementById("birthdayRequired");

          if (birthdayInput.value.trim() === "") {
            birthdayRequired.style.display = "inline"; // Show asterisk span
    } else {
            birthdayRequired.style.display = "none"; // Hide asterisk span
    }
  }
      </script>


</body>

</html>