
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Style2.css">
    <title>wheretouse</title>
    <style>
        .places{
            text-align: center;
            margin:  0% 10%;
            color: rgba(133,187,101);
            font-weight: 600;
            font-family: Merriweather;
            font-size: 4em;
}
 

            .sidenav {
            height: 100%;
            width: 0; 
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: rgb(87 107 237);
            overflow-x: hidden;
            padding-top: 20px;
            transition: 0.5s;
        }

        .sidenav a {
            padding: 10px 20px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
			font-weight:500;
        }

        .sidenav a:hover {
            background-color: #ddd;
        }

       
        .content {
            margin-left: 250px; 
            padding: 30px;
        }

        /* CSS for the open/close button */
        .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: rgb(87 107 237);
            color: white;
            padding: 10px 15px;
            border: none;
            position: fixed;
            top: 20px;
            left: 10px;
            z-index: 2;
			
        }
    </style>

</head>
<nav class="sidenav" id="mySidenav">
		<button class="openbtn" onclick="toggleNav()">☰</button>
        <a href="Dashboardhome.php">HOME</a>
        <a href="profile.php">My Profile</a>
        <a href="Logout.php">Logout</a>
    	</nav>
<body style="background-color:white; margin-top:50px;">


       
      
        <div style="text-align: center;">
                  <button id = "btnback" onclick="goBack()" style=" background-color: rgb(87 107 237);border: none;color: white;padding: 10px 20px; text-align: center;text-decoration: none;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;border-radius: 4px;">Go Back</button>
            </div>
    <script>
        function goBack() {
            window.history.back();
        }
        </script>
        <script>
         function toggleNav() {
        var sidebar = document.getElementById("mySidenav");
        var btn = document.querySelector(".openbtn");
        if (sidebar.style.width === "0px" || sidebar.style.width === "") {
            sidebar.style.width = "250px";
            sidebar.classList.add("opened");
			btn.style.left = "250px";
            btn.innerHTML = "✕";
        } else {
            sidebar.style.width = "0";
            sidebar.classList.remove("opened");
			btn.style.left = "10px";
            btn.innerHTML = "☰";
        }
    }
    
    </script>
</body>
</html>
