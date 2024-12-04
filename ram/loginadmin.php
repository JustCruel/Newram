<?php
session_start();
include 'config/connection.php';
$errors = array();

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Login</title>
      <link rel="stylesheet" href="css/Log-in.css">  
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body{
                background: white;
            }
        </style>

   </head>
   <header>
         <nav>
    <ul>
      <li><a href="Home.php" target="_self" class="aheader"> Home</a></li>
      <li><a href="log-in.php" target="_self" class="aheader" >Login User</a></li>

      
    </ul>
    </nav>
    </header>


<?php 
      $msg ="";

       if (isset($_POST['Login'])) {
      
        $password = mysqli_real_escape_string($conn, $_POST['password']);
         $admin1 = mysqli_real_escape_string($conn, $_POST['username']);
    
       if(empty($password)){
         array_push($errors,"<h4 style='background-color:#tomato; text-align:center; color:#FFFFFF;'>Password is required!</h4>");
       }

        $check_email = mysqli_query($conn,"select * from admin WHERE admin='{$admin1}' AND password='{$password}'");

        if (mysqli_num_rows($check_email) > 0 ) {
           $row = mysqli_fetch_assoc($check_email);
           $_SESSION['id'] = $row['id'];
           $_SESSION['email'] = $row['admin'];
           $currentDateTime = date('Y-m-d H:i:s');
           $audit = mysqli_query($conn,"Insert into audit(email,logintime)  values ('{$admin1}','{$currentDateTime}')");
           header("location: dashboardadmin.php");
           $currentDateTime = date('Y-m-d H:i:s');
           $audit = mysqli_query($conn,"Insert into audit(email,logintime)  values ('{$admin1}','{$currentDateTime}')");
        }else{
           $msg="<div class= 'alert alert-danger' style='background-color:#BF0210; text-align:center; color:#FFFFFF;'> Invalid Username and Password!</div>";
            $check_email = mysqli_query($conn,"select * from admin WHERE admin='{$admin1}' AND Password='{$password}'");

        }

       
}

 ?>




<script type="text/javascript">
window.addEventListener("scroll", function(){
   var header = document.querySelector("header");
   header.classList.toggle("sticky", window.scrollY > 0);
})
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
</script>
   <body><br><br>
      <div class="wrapper">
         <div class="title-text">
            <div class="title login">
               <p>Administrator Login</p>
            </div>
          </div>
         <div class="form-container">
            <br>
            <div class="form-inner">
               <form method="POST" action="#" class="login">
                 <?php echo $msg;  ?>
                  <div class="field">
                     <input type="text" name="username" placeholder="Admin"  min="1" max="10"required>
                  </div>
                  <div class="field">
                     <input type="password" name="password" placeholder="Password" id="pass2" min="1" max="20" required>
                  </div>
                  <div position: absolute><input type="checkbox" onclick="myFunction1()"> Show Password</input>
                     </div>
                  <div class="field btn">
                     <div class="btn-layer"></div>
                     <input type="submit" name="Login" value="Log in">
                  </div>
   
               </form>
               <form action="#" class="signup">
                  <div class="field" >
                     <input type="email" placeholder="Email Address" required>
                  </div>


                  <div class="field">
                     <div class="text"></div>
                        <input onkeyup="trigger()" type="password" placeholder=" New Password" class="input" id="pass1" required  >
                        <div class="indicator">
                        <span class="weak"></span>
                        <span class="medium"></span>
                        <span class="strong"></span>
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
                 function trigger(){
                   if(input.value != ""){
                     indicator.style.display = "block";
                     indicator.style.display = "flex";
                     if(input.value.length <= 3 && (input.value.match(regExpWeak) || input.value.match(regExpMedium) || input.value.match(regExpStrong)))no=1;
                     if(input.value.length >= 6 && ((input.value.match(regExpWeak) && input.value.match(regExpMedium)) || (input.value.match(regExpMedium) && input.value.match(regExpStrong)) || (input.value.match(regExpWeak) && input.value.match(regExpStrong))))no=2;
                     if(input.value.length >= 6 && input.value.match(regExpWeak) && input.value.match(regExpMedium) && input.value.match(regExpStrong))no=3;
                     if(no==1){
                       weak.classList.add("active");
                       text.style.display = "block";
                       text.textContent = "Your new password is weak";
                       text.classList.add("weak");
                     }
                     if(no==2){
                       medium.classList.add("active");
                       text.textContent = "Your new password is medium";
                       text.classList.add("medium");
                     }else{
                       medium.classList.remove("active");
                       text.classList.remove("medium");
                     }
                     if(no==3){
                       weak.classList.add("active");
                       medium.classList.add("active");
                       strong.classList.add("active");
                       text.textContent = "Your new password is strong";
                       text.classList.add("strong");
                     }else{
                       strong.classList.remove("active");
                       text.classList.remove("strong");
                     }
                     showBtn.style.display = "block";
                     showBtn.onclick = function(){
                       if(input.type == "password"){
                         input.type = "text";
                         showBtn.textContent = "HIDE";
                        
                       }else{
                         input.type = "password";
                         showBtn.textContent = "SHOW";
                       
                       }
                     }
                   }else{
                     indicator.style.display = "none";
                     text.style.display = "none";
                     showBtn.style.display = "none";
                   }
                 }
                 </script>
             </form>
            </div>
         </div>
      </div>
      <div></div>

   </body>

</html>