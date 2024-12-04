<?php
session_start();
include "config/connection.php"; // Database connection
include "sidebar.php"; // Include the sidebar
error_reporting(0);
$errors = array();
$user_id = $_SESSION['id']; // Get the user's ID from the session
$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

$province_id = $user['province_id'];
$municipality_id = $user['municipality_id'];
$barangay_id = $user['barangay_id'];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Personal Data</title>
  <link rel="stylesheet" type="text/css" href="css/Registerstyle.css">
  <link rel="stylesheet" type="text/css" href="css/home.css">
  <link rel="stylesheet" type="text/css" href="css/updatepass.css">
  <link rel="icon" href="images/logo-cab.png">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      /* Use flexbox for layout */
    }


    .main-content {
      margin-left: 250px;
      /* Space for the sidebar */
      padding: 30px;
      /* Padding for the main content */
      flex-grow: 1;
      /* Allows the main content to expand */
      background-color: #f9f9f9;
      /* Background color for the main content */
      height: 100vh;
      /* Full height */
      overflow-y: auto;
      /* Scrollable if content exceeds viewport */
    }

    .container {
      max-width: 1200px;
      /* Max width for the container */
      margin: auto;
      /* Center the container */
      padding: 20px;
      /* Padding inside the container */
      border: 1px solid #ccc;
      /* Border for the container */
      border-radius: 10px;
      /* Rounded corners */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      /* Shadow effect */
    }

    /* Additional styles as needed */
  </style>
</head>

<body>


  <div class="main-content">
    <div class="container">
      <h2 class="title">Update Personal Data</h2>
      <div class="contents">
        <form action="" method="POST">
          <?php include('errors.php'); ?>
          <div class="user-details">
            <div class="input-box">
              <span style="font-size:24px;font-weight:500;">Update Information</span>
              <label class="details">E-mail</label>
              <input type="email" placeholder="E-mail" name="Email" value="<?php echo $_SESSION['email']; ?>" required>

              <label class="details">First Name</label>
              <input type="text" placeholder="First Name" name="Fname" value="<?php echo $_SESSION['firstname']; ?>">

              <label class="details">Middle Name</label>
              <input type="text" placeholder="Middle Name" name="Mname" value="<?php echo $_SESSION['middlename']; ?>">

              <label class="details">Last Name</label>
              <input type="text" placeholder="Last Name" name="Lname" value="<?php echo $_SESSION['lastname']; ?>">

              <label class="details">Gender</label>
              <input type="text" placeholder="Gender" name="gender" value="<?php echo $_SESSION['gender']; ?>">

              <div class="input-box">
                <label class="details">Province <span style="color: red;">*</span></label>
                <select id="state" name="province">
                  <option value="">Select Province/State</option>
                  <?php
                  $query = "SELECT * FROM provincestate ORDER BY provincestate ASC";
                  $result = mysqli_query($conn, $query);
                  while ($row = mysqli_fetch_assoc($result)) {
                    $selected = ($row['province_id'] == $province_id) ? 'selected' : '';
                    echo "<option value='{$row['province_id']}' {$selected}>{$row['provincestate']}</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="input-box">
                <label class="details">Municipality/City <span style="color: red;">*</span></label>
                <select id="city" name="city">
                  <option value="">Select Municipality</option>
                  <?php
                  if ($province_id) {
                    $query = "SELECT * FROM municipalities WHERE province_id = $province_id ORDER BY municipality ASC";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                      $selected = ($row['municipality_id'] == $municipality_id) ? 'selected' : '';
                      echo "<option value='{$row['municipality_id']}' {$selected}>{$row['municipality']}</option>";
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="input-box">
                <label class="details">Barangay <span style="color: red;">*</span></label>
                <select id="street" name="barangay">
                  <option value="">Select Barangay</option>
                  <?php
                  if ($municipality_id) {
                    $query = "SELECT * FROM barangay WHERE municipality_id = $municipality_id ORDER BY barangay ASC";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                      $selected = ($row['barangay_id'] == $barangay_id) ? 'selected' : '';
                      echo "<option value='{$row['barangay_id']}' {$selected}>{$row['barangay']}</option>";
                    }
                  }
                  ?>
                </select>
              </div>

              <p style="font-size: 12px; color: black;">
                By clicking 'Update Data', you agree to use the data above as information for future submission of an
                inquiry form, requesting a document, or filing a complaint. In accordance with the Data Privacy Act of
                2012 (RA 10173), we assure you to keep the data confidential and will not be used in any unrelated and
                insignificant transactions.
              </p>

              <div class="button">
                <input type="submit" value="Update Data" name="Update" id="button"
                  onclick="return confirm('Are You Sure! You want to Update your Information?')">
              </div>
            </div>
        </form>
        <div style="text-align: center;">
          <button id="btnback" onclick="goBack()"
            style="background-color: rgba(133, 187, 101); border: none; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 4px;">
            Go Back
          </button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
    $(document).ready(function () {
      function loadMunicipalities(stateId, selectedMunicipality) {
        if (stateId) {
          $.ajax({
            type: 'POST',
            url: 'fetch_municipalities.php',
            data: 'state_id=' + stateId,
            success: function (html) {
              $('#city').html(html);
              if (selectedMunicipality) {
                $('#city').val(selectedMunicipality);
                loadBarangays(selectedMunicipality, <?php echo json_encode($barangay_id); ?>);
              }
            }
          });
        } else {
          $('#city').html('<option value="">Select Municipality</option>');
          $('#street').html('<option value="">Select Barangay</option>');
        }
      }

      function loadBarangays(cityId, selectedBarangay) {
        if (cityId) {
          $.ajax({
            type: 'POST',
            url: 'fetch_barangays.php',
            data: 'city_id=' + cityId,
            success: function (html) {
              $('#street').html(html);
              if (selectedBarangay) {
                $('#street').val(selectedBarangay);
              }
            }
          });
        } else {
          $('#street').html('<option value="">Select Barangay</option>');
        }
      }

      // Event listener for state change
      $('#state').change(function () {
        var stateId = $(this).val();
        loadMunicipalities(stateId);
      });

      // Event listener for city change
      $('#city').change(function () {
        var cityId = $(this).val();
        loadBarangays(cityId);
      });
    });

    function goBack() {
      window.history.back();
    }
  </script>
</body>

</html>