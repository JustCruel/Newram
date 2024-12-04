<?php
session_start();
include "config/connection.php";
error_reporting(0);
$errors = array();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Password</title>
  <link rel="stylesheet" type="text/css" href="css/updatepass.css">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <style>
    header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      display: flex;
      background-color: rgba(133, 187, 101);
      justify-content: space-between;
      align-items: center;
      padding: 10px 10px;
      transition: 0.2s;
      z-index: 100000;
    }

    header.sticky {
      padding: 10px 10px;
      background: rgba(133, 187, 101, 0.8);
    }

    header.sticky ul li a {
      color: white;
    }

    header.sticky ul li a:hover {
      color: black;
    }

    .logo {
      margin-left: 10px;
      width: 50px;
      height: 45px;
    }

    ul,
    li {
      display: inline-block;
      padding: 0px 15px;
    }

    li {
      list-style-type: none;
    }

    li .aheader {

      text-decoration: none;
      color: black;
      font-size: 15px;
      float: right;
    }

    li .aheader:hover {
      color: white;
      background-color: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6));
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
    var z = document.getElementById("pass3");
    if (x.type === "password" || y.type === "password") {
      x.type = "text";
      y.type = "text";
      z.type = "text";
    } else {
      x.type = "password";
      y.type = "password";
      z.type = "password"
    }
  }
</script>

<header>
  <nav>
    <ul>
      <li><a href="Home.php" target="_self" class="aheader"> Home</a></li>
      <li><a href="profile.php" target="_self" class="aheader">My Profile</a></li>
      <li><a href="Registration.php" target="_self" class="aheader"> About Us</a></li>
      <li><a href="Logout.php" target="_self" class="aheader">Logout</a></li>
    </ul>
  </nav>
</header>


<?php

// $msg="";

if (isset($_POST['Update'])) {
  $emailusername = mysqli_real_escape_string($conn, $_POST['Email']);
  $old_pass = mysqli_real_escape_string($conn, md5($_POST['old_pass']));
  $Password = mysqli_real_escape_string($conn, $_POST['Password']);
  $PasswordConf = mysqli_real_escape_string($conn, $_POST['PasswordConf']);
  $sql = mysqli_query($conn, "SELECT password from users WHERE password = '{$old_pass}' ");
  $check_pwd = mysqli_fetch_array($sql);
  $user_data = $check_pwd['password'];


  if ($Password != $PasswordConf) {
    array_push($errors, "<h4 style='background-color:#BF0210; text-align:center; color:#FFFFFF;'>Your New Password and Confirm Password does not Match!.</h4>");
  }
  $uppercase = preg_match('@[A-Z]@', $Password);
  $lowercase = preg_match('@[a-z]@', $Password);
  $number = preg_match('@[0-9]@', $Password);
  $specialChars = preg_match('@[^\w]@', $Password);
  if (!$specialChars || !$uppercase || !$lowercase || !$number || strlen($Password) < 8) {
    array_push($errors, "<h4 style='background-color:#BF0210; text-align:center; color:#FFFFFF; font-size:12px;'>Password should be at least 8 characters in Length and should include at least 1 Upper and Lower Case Letter, 1 Symbol,and 1 Number!.</h2>");
  }

  if (count($errors) == 0) {
    if ($user_data == $old_pass) {
      $Password = md5($PasswordConf);
      $update_pwd = mysqli_query($conn, "UPDATE users SET password='{$Password}' WHERE email  = '{$emailusername}' OR username  = '{$emailusername}'");
      $query = mysqli_query($conn, "select * from users where email = '{$emailusername}' OR username = '{$emailusername}'");
      if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $_SESSION['id'] = $row['id'];
        echo "<script>alert('Your Password is Updated Sucessfully!'); window.location='profile.php'</script>";
      } else {
        array_push($errors, "<h4 style='background-color:#BF0210; text-align:center; color:#FFFFFF;'>Your  Email is Incorrect!.</h4>");
      }
    } else {
      //$msg = "<div class= 'alert alert-danger'>Your Old Password has Incorrect!.</div>";
      array_push($errors, "<h4 style='background-color:#BF0210; text-align:center; color:#FFFFFF;'>Your Old Password has Incorrect!.</h4>");
    }
  }

}


?>



<body><br><br><br><br>
  <div class="box">
    <div class="title"><span> Update Password</span></div>
    <form method="POST" action="#">
      <br>
      <?php include('errors.php'); ?>
      <div class="input-box">
        <span class="details">Email</span>
        <input type="text" name="Email" placeholder="Email/Username" value="<?php echo $emailusername ?>" required>
      </div>
      <div class="input-box">
        <span class="details">Old Password
          <input type="password" placeholder=" Confirm Password" name="old_pass" id="pass2">

      </div>
      <div class="input-box">
        <span class="details">New Password
          <span class="text"></span></span>
        <input onkeyup="trigger()" type="password" placeholder="New Password" class="input" name="Password" id="pass1">
        <div class="indicator">
          <span class="weak"></span>
          <span class="medium"></span>
          <span class="strong"></span>
        </div>
      </div>
      <div class="input-box">
        <span class="details">Confirm Password
          <span class="text"></span></span>
        <input type="password" placeholder=" Confirm Password" name="PasswordConf" id="pass3">
      </div>
      <br>
      <div>
        <input type="checkbox" onclick="myFunction1()"> Show Password
      </div>

      <div class="button">
        <input type="submit" name="Update" id="change" value="Update Password">
      </div>
    </form>

  </div>
  </div>

  <script type="text/javascript">
    const indicator = document.querySelector(".indicator");
    const input = document.querySelector(".input");
    const weak = document.querySelector(".weak");
    const medium = document.querySelector(".medium");
    const strong = document.querySelector(".strong");
    const text = document.querySelector(".text");
    const showBtn = document.querySelector(".showBtn");
    let regExpWeak = /[a-z]/;
    let regExpMedium = /\d+/;
    let regExpStrong = /.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/;
    function trigger() {
      if (input.value != "") {
        indicator.style.display = "block";
        indicator.style.display = "flex";
        if (input.value.length <= 3 && (input.value.match(regExpWeak) || input.value.match(regExpMedium) || input.value.match(regExpStrong))) no = 1;
        if (input.value.length >= 6 && ((input.value.match(regExpWeak) && input.value.match(regExpMedium)) || (input.value.match(regExpMedium) && input.value.match(regExpStrong)) || (input.value.match(regExpWeak) && input.value.match(regExpStrong)))) no = 2;
        if (input.value.length >= 6 && input.value.match(regExpWeak) && input.value.match(regExpMedium) && input.value.match(regExpStrong)) no = 3;
        if (no == 1) {
          weak.classList.add("active");
          text.style.display = "inline";
          text.textContent = "  (Your password is weak)";
          text.classList.add("weak");
        }
        if (no == 2) {
          medium.classList.add("active");
          text.textContent = "  (Your password is medium)";
          text.classList.add("medium");
        } else {
          medium.classList.remove("active");
          text.classList.remove("medium");
        }
        if (no == 3) {
          weak.classList.add("active");
          medium.classList.add("active");
          strong.classList.add("active");
          text.textContent = "  (Your password is strong)";
          text.classList.add("strong");
        } else {
          strong.classList.remove("active");
          text.classList.remove("strong");
        }
        showBtn.style.display = "block";
        showBtn.onclick = function () {
          if (input.type == "password") {
            input.type = "text";
            showBtn.textContent = "HIDE";

          } else {
            input.type = "password";
            showBtn.textContent = "SHOW";

          }
        }
      } else {
        indicator.style.display = "none";
        text.style.display = "none";
        showBtn.style.display = "none";
      }
    }
  </script>
</body>

</html>