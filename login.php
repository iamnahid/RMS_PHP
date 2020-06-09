<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tara Limited</title>
    <link rel="icon" type="image/gif/png" href="./assets/img/Other/icon.png">
    
    <link rel="stylesheet" href="./assets/css/style.css">
    <!------------------------ FONT STYLES -------------------->
    <link href="https://fonts.googleapis.com/css?family=Bebas+Neue|PT+Sans|Poppins|Roboto+Mono&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="subcontainer">
            <img src="./assets/img/bg.jpg" style="z-index:0;" alt="">
            <div class="overlay1" style="z-index:0;">
            </div>
            <div class="overlay" style="z-index:1;">
                <div class="rect" style="z-index:1;" id="r1"><img src="./assets/img/LOGO/KSML.png" alt=""></div>
                <div class="rect" style="z-index:1;" id="r2"><img src="./assets/img/LOGO/TSML.png" alt=""></div>
                <div class="rect" style="z-index:1;" id="r3"><img src="./assets/img/LOGO/ESML.png" alt=""></div>
                <div class="rect" style="z-index:1;" id="r4"><img src="./assets/img/LOGO/TL.png" alt=""></div>
            </div>

            <div class="subcontainer1" style="z-index:1000;">
                <form class="login" action="login.php" method="post">
                    <h1>Please Log In to Continue</h1><br><br><br><br>
                    <input type="text" name="uname" id="uname" placeholder="Username">
                    <br><br>
                    <input type="password" name="pass" id="pass" placeholder="Password">
                    <br><br><br><br>
                    <input type="submit" id="submit" value="Log In">
                    <br>
                    <div class="error">
                        <?php 
                            if(isset($_GET['msg']))
                            
                            echo $_GET['msg'];
                        ?>
                    </div>   
                </form>
            
                <div class="footer">
                    <p>Copyright &copy2020 <a href="https://iamnahid.github.io">iamnahid</a>. All rights reserved</p>
                    <div class="cert">
                        <img src="./assets/img/CERT/BCI.png" alt="">
                        <img src="./assets/img/CERT/BSCI.png" alt="">
                        <img src="./assets/img/CERT/GOTS.png" alt="">
                        <img src="./assets/img/CERT/CIT.png" alt="">
                        <img src="./assets/img/CERT/URS.png" alt="">
                    </div>
                
                </div>
            </div>
        </div>
        
    </div>    
</body>
</html>

<?php
    if ($_POST)
    {
        require("./dbConnect.php");

        $u = $_POST['uname'];
        $p = $_POST['pass'];

        $sql = "SELECT uname,pass,type FROM users WHERE uname='$u' AND pass='$p'";
      
        $result = mysqli_query($conn, $sql);     
        $row = mysqli_fetch_row($result);
      

        if( $row[0] === $u && $row[1] === $p && $row[2] === "normal")
        {
            session_start();
            $_SESSION['userid'] = $u;
            $_SESSION['utype'] = "normal";
            $_SESSION['uname'] = session_id();
            $_SESSION['last_login_timestamp'] = time();
            header("Location: home.php");                
        }
        else if ( $row[0] === $u && $row[1] === $p && $row[2] === "moderator"){
            session_start();
            $_SESSION['userid'] = $u;            
            $_SESSION['utype'] = "moderator";
            $_SESSION['uname'] = session_id();
            $_SESSION['last_login_timestamp'] = time();
            header("Location: moderator.php");   
        }
        else if ( $row[0] === $u && $row[1] === $p && $row[2] === "accounts"){
            session_start();
            $_SESSION['userid'] = $u;            
            $_SESSION['utype'] = "accounts";
            $_SESSION['uname'] = session_id();
            $_SESSION['last_login_timestamp'] = time();
            header("Location: accounts.php");   
        }
        else if ( $row[0] === $u && $row[1] === $p && $row[2] === "admin"){
            session_start();
            $_SESSION['userid'] = $u;
            $_SESSION['utype'] = "admin";
            $_SESSION['uname'] = session_id();
            $_SESSION['last_login_timestamp'] = time();
            header("Location: admin.php");   
        }
        else
        {
            $msg = "Incorrect Username or Password";
            header("Location: login.php?msg=$msg");
        }
    
    }


?>