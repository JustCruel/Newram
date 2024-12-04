<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pass = $_POST["password"];

    if (empty($email) || empty($pass)) {
        header("Location: index.php?empty=1");
        exit();
    } else {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "tourist";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM users WHERE email='{$email}' AND password ='{$pass}'";
        $result = $conn->query($sql);

        if ($result->num_rows >= 1) {
           
            session_start();
            $_SESSION["email"] = $email;
            $row = $result->fetch_assoc();
            header("Location: Dashboard.php");
            exit();
        } else {
            
            header("Location: index.php?loginfailed=1");
            exit();
        }

        $conn->close();
    }
}
?>