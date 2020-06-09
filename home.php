<?php
    ob_start();

    session_start();

    $valid_session = isset($_SESSION['uname']) ? $_SESSION['uname'] === session_id() : FALSE;
    if (!$valid_session || $_SESSION['utype'] != "normal") {
        
        
?>
        <div class="errorPage">
            <h1 style="position:relative;top: 0%;color: rgb(255, 0, 76); font-family: 'Bebas Neue',sans-serif;font-size: 3em;text-align:center;">You aren't Logged in!<h2>
            <img align="center" src="./assets/img/Other/failed.png" alt="">
            <p style="position:relative;top: 0%;font-family: 'Bebas Neue',sans-serif;font-size: 2em;text-align:center;">Please <a style="color: rgb(255, 0, 76); font-family: 'Bebas Neue',sans-serif;font-size: 1em;text-align:center;" href="login.php"> Log In</a> </p>
            
        </div>
        

        <style>
            body{
                background-color: white;
            }
            .errorPage{
                position: absolute;
                top: 25%;
                left: 20%;
                width: 60%;
                height: 400px;
                border: 2px solid red;
                border-radius: 10px;
                -webkit-border-radius: 10px;
                -moz-border-radius: 10px;
                -ms-border-radius: 10px;
                -o-border-radius: 10px;
                text-align: center;
            }
            .errorPage img{
                position: relative;
                margin-left: auto;
                margin-right: auto;
                width: 150px;
                height: 150px;
            }
        </style>
        
<?php

        exit();
    }

    else{       

        if (( time() - $_SESSION['last_login_timestamp'])> 300)
        {
            header('Location: logout.php');   
        }

        else
        {
            $uid = $_SESSION['userid'];
            $ut = $_SESSION['utype'];
            $_SESSION['last_login_timestamp']= time();
        
            require("./dbConnect.php");
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/gif/png" href="./assets/img/LOGO/TL.png">
        <title>HOME</title>

        <link rel="stylesheet" href="./assets/css/home.css">
        <!------------------------ FONT STYLES -------------------->
        <link href="https://fonts.googleapis.com/css?family=Bebas+Neue|PT+Sans|Poppins|Roboto+Mono|Nanum+Gothic&display=swap" rel="stylesheet">
        <!------------------------ JAVASCRIPT --------------------->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <script>
        function notifyFunc() {
            var x = document.getElementById("notify-content");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
    <body>
        <div class="contain">
            <div class="navbar" style="z-index: 1;">
                <div class="rows">
                    <div class="userName"><p>Welcome, <span><?=$uid?></span></p></div>
                    <div class="tit"></div>
                    <div class="menu">
                        <a href="./home.php">Home</a>
                        <a href="./addItems.php">Add Section</a>
                        <a href="./requisitionForm.php">Requisition Form</a>
                        <a href="">My Panel</a>
                    </div>
                    <div class="logOut" onclick="window.location.href='./logout.php'">
                        <img src="./assets/img/Other/off.png" onclick="window.location.href='./logout.php'" alt="">
                    </div>
                </div>
                <div class="rows1">
                    <h3></h3>
                </div>
            </div>
            <div class="bodySec" style="z-index: 0;">
                <div class="col" id="dash">
                    <div class="dash-titles" id="dash-h1">Dashboard</div>
                    <div class="dash-contents">
                        <div>Add Category</div>
                        <div>Add Subcategory</div>
                        <div>Add Description</div>
                        <div>Add Units</div>
                    </div>
                </div>
                <div class="col" id="table-data">
                    <div class="dash-titles">Requisition History</div>
                    <div class="table-contents">
                        <?php
                            require("./dbConnect.php");
                            function getTableDataFromDB($s)
                            {
                                require("./dbConnect.php");
                                $res1 = mysqli_query($conn, $s)or die(mysqli_error());
                                $ar=array();
                                while($r = mysqli_fetch_assoc($res1)) {
                                    $ar[]=$r;
                                }
                                return json_encode($ar);
                            }

                            // $s1=" SELECT t2.req_order_id,  t1.* FROM req_offer AS t1 INNER JOIN req_offer_items AS t2 WHERE t1.r_id = t2.req_order_id ";
                            $s1=" SELECT * FROM req_offer";
                            // echo $s1;
                            $jn1=getTableDataFromDB($s1);
                            //echo $jsn;
                            $jr1=json_decode($jn1);
                            
                            echo '<table id="tab">';
                            echo "<th>R_ID</th><th>User Name</th><th>Up Time</th><th>Status</th><th>";
                            foreach($jr1 as $table)
                            {
                                echo '<tr align="center">';
                                if( $table->r_status == '0')
                                {
                                    $status = 'Pending';
                                }
                                else{
                                    $status = 'Cleared';
                                }
                                echo 
                                '<td>'.$table->prefix.' '.$table->r_id.'</td><td>'.$table->r_uname.'</td>'.'</td><td>'.$table->r_uptime.'</td>'.'</td><td>'.$status.'</td>';
                                echo '</tr>';
                            }
                            echo '</table>';                    
                        ?>
                    </div>
                </div>
                <div class="col" id="notify">
                    <div class="dash-titles" onclick="notifyFunc()" id="notify-title">Notifications &darr;</div>
                    <div id="notify-content">
                        <span>Emergency:  Machine **** Has Power Problem</span>
                        <span>Emergency:  Machine **** Has Belt Problem</span>
                        <span>Machine ****  is currently off</span>
                    </div>
                </div>                       
            </div>
        </div>
        
    </body>
    </html>

<?php

    }
}

?>