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
        <link rel="stylesheet" href="./assets/css/addSection.css">

        <!------------------------ FONT STYLES -------------------->
        <link href="https://fonts.googleapis.com/css?family=Bebas+Neue|PT+Sans|Poppins|Roboto+Mono|Nanum+Gothic&display=swap" rel="stylesheet">
        <!------------------------ JAVASCRIPT --------------------->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <script>
        function showItem(e){
            var x = document.getElementById('itemTit');
            var y = document.getElementById('addItem');
            if (x.style.display === "block") {
                x.style.display = "none";
                y.style.display = "block";
            } else {
                x.style.display = "block";
                y.style.display = "none";
            }  
        }
        function showCat(e){
            var x = document.getElementById('catTit');
            var y = document.getElementById('addCat');
            if (x.style.display === "block") {
                x.style.display = "none";
                y.style.display = "block";
            } else {
                x.style.display = "block";
                y.style.display = "none";
            }  
        }
        function showDet(e){
            var x = document.getElementById('detTit');
            var y = document.getElementById('addDet');
            if (x.style.display === "block") {
                x.style.display = "none";
                y.style.display = "block";
            } else {
                x.style.display = "block";
                y.style.display = "none";
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
            <div class="bodyDiv" id="bodyDiv" style="z-index: 0;">
                <div class="colSec" id="addCol">
                    <div class="addSec" id="itemAdd">
                        <a href="#" id="itemTit" onclick="showItem(this)">Click to Add Department</a>
                        <form action="./addItems.php" name="addItem" id="addItem" method="post">
                            <input type="text"  name="aItem" id="aItem" placeholder="Type Item Name"><br>
                            <input type="text"  name="aItemRefId" id="aItemRefId" placeholder="Type Item Ref ID"><br>
                            <input type="submit" name="aItemSub" id="aItemSub" value="ADD">
                            <?php
                                require("./dbConnect.php");
                                if (isset($_POST['aItemSub']))
                                {
                                    if (!empty($_POST["aItem"]) && !empty($_POST["aItemRefId"]))
                                    {                                       

                                        $iName = $_POST["aItem"];
                                        $iRef = $_POST["aItemRefId"];

                                        $iSql = " INSERT INTO `items`(`itemCode`, `itemName`) VALUES ('$iRef', '$iName') ";
                                        
                                        echo $iSql;

                                        $iResult = mysqli_query($conn, $iSql); 

                                        if (!$iResult) {
                                        printf("Errormessage: %s\n", mysqli_error($conn));
                                        }
                                        
                                    
                                        $conn->close();
                                        echo "<h1 style='color:green;'>Added</h1>";
                                        // header("Refresh:0; url=addItems.php");
                                    }
                                    else{
                                        echo "<h5 style='color:RED;'>Can't be Empty!</h5>";
                                    }
                                    

                                }
                            
                            ?>
                        </form>
                    </div>
                    <div class="addSec" id="catAdd">
                        <a href="#" id="catTit" onclick="showCat(this)">Click to Add Categories</a>
                        <form action="./addItems.php" name="addCat" id="addCat" method="post">
                            <div id="catForm">
                                <div class="col">
                                    <select name="items" id="items">
                                        <option  value="">Select Item</option>
                                        <?php
                                            function getJSONFromDB($sql)
                                            {
                                                require("./dbConnect.php");
                                                $result = mysqli_query($conn, $sql)or die(mysqli_error());
                                                $arr=array();
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    $arr[]=$row;
                                                    //echo $row["name"];echo $row["id"];echo "<br>";
                                                }
                                                return json_encode($arr);
                                            }
                                            $i1 = "SELECT * from items";
                                            $json1 = getJSONFromDB($i1);
                                            $decJs1 = json_decode($json1);
                                            
                                            foreach($decJs1 as $v1)
                                            {
                                                echo "<option value='$v1->itemCode'>".$v1->itemName."</option>";
                                            }
                                            
                                        ?>
                                    </select><br>
                                    <input type="text"  name="aCat" id="aCat" placeholder="Type Category Name"><br>
                                    <input type="text"  name="aCatRefId" id="aCatRefId" placeholder="Type Category Ref ID"><br>
                                </div>
                                <div class="col">
                                    <input type="submit" name="aCatSub" id="aCatSub" value="ADD">
                                </div> 
                            </div>                                         
                            <?php
                                require("./dbConnect.php");
                                if (isset($_POST['aCatSub']))
                                {
                                    if ( $_POST["items"] !="Select Item" && !empty($_POST["aCat"]) && !empty($_POST["aCatRefId"]))
                                    {                                       
                                        $item = $_POST["items"];
                                        $cName = $_POST["aCat"];
                                        $cRef = $_POST["aCatRefId"];

                                        $cSql = " INSERT INTO `categories`(`categoryCode`, `categoryName`, `itemCode`) VALUES ('$cRef', '$cName', '$item') ";
                                        
                                        echo $cSql;

                                        $cResult = mysqli_query($conn, $cSql); 

                                        if (!$cResult) {
                                        printf("Errormessage: %s\n", mysqli_error($conn));
                                        }
                                        
                                    
                                        $conn->close();
                                        echo "<h1 style='color:green;'>Added</h1>";
                                        header("Refresh:0; url=addItems.php");
                                    }
                                    else{
                                        echo "<h5 style='color:RED;'>Can't be Empty!</h5>";
                                    }
                                    

                                }
                            
                            ?>
                        </form>
                    </div>
                    <div class="addSec" id="detAdd">
                        <a href="#" id="detTit" onclick="showDet(this)">Click to Add Details</a>
                        <form action="./addItems.php" name="addDet" id="addDet" method="post">
                            
                            <select name="ditems"  id="ditems">
                                <option value="">Select Item</option>
                                <?php
                                    require("./dbConnect.php");
                                    $dql = " SELECT t1.categoryCode, t1.categoryName, t2.itemCode, t2.itemName
                                    FROM categories AS t1 INNER JOIN items AS t2 ON t1.itemCode = t2.itemCode ";

                                    function getCatDetFromDB($mySql)
                                    {
                                        require("./dbConnect.php");
                                        $res = mysqli_query($conn, $mySql)or die(mysqli_error());
                                        $array=array();
                                        while($rows = mysqli_fetch_assoc($res)) {
                                            $array[]=$rows;
                                            //echo $row["name"];echo $row["id"];echo "<br>";
                                        }
                                        return json_encode($array);
                                    }
                                    $j1 = getCatDetFromDB($dql);
                                    $dJs1 = json_decode($j1);
                                    
                                    foreach($dJs1 as $a1)
                                    {
                                        echo "<option value='$a1->categoryCode'>".$a1->categoryCode."-".$a1->categoryName." - ".$a1->itemName." - ".$a1->itemCode."</option>";
                                    }
                                    

                                ?>
                            </select><br>
                            <input type="text" name="aDet" placeholder="Type Details" id="aDet">
                            <input type="text" name="aDetRefId" placeholder="Type Details Ref ID" id="aDetRefId">
                            <input type="submit" name="aDetSub" id="aDetSub" value="ADD">
                            <?php
                                require("./dbConnect.php");
                                if (isset($_POST['aDetSub']))
                                {
                                    if ( $_POST["ditems"] !="Select Item" && !empty($_POST["aDet"]) && !empty($_POST["aDetRefId"]))
                                    {                                       
                                        $dItem = $_POST["ditems"];
                                        $dName = $_POST["aDet"];
                                        $dRef = $_POST["aDetRefId"];

                                        $dSql = " INSERT INTO `product`(`productId`, `description`, `categoryCode`) VALUES ('$dRef', '$dName', '$dItem') ";
                                        
                                        echo $dSql;

                                        $dResult = mysqli_query($conn, $dSql); 

                                        if (!$dResult) {
                                        printf("Errormessage: %s\n", mysqli_error($conn));
                                        }
                                        
                                    
                                        $conn->close();
                                        echo "<h1 style='color:green;'>Added</h1>";
                                        header("Refresh:0; url=addItems.php");
                                    }
                                    else{
                                        echo "<h5 style='color:RED;'>Can't be Empty!</h5>";
                                    }
                                }
                            ?>
                        </form>
                    </div>
                    
                </div>
                <div class="colSec" id="table1">
                    <h1 class="dash-titles">All Item Details</h1>
                    <div class="table-product-data">
                        <?php
                            require("./dbConnect.php");
                            function getTableDataFromDB($s)
                            {
                                require("./dbConnect.php");
                                $res = mysqli_query($conn, $s)or die(mysqli_error());
                                $ar=array();
                                while($r = mysqli_fetch_assoc($res)) {
                                    $ar[]=$r;
                                }
                                return json_encode($ar);
                            }

                            $s1=" SELECT t2.itemCode, t2.itemName, t1.categoryName, t1.categoryCode, t1.itemCode, t3.description, t3.productId, t3.categoryCode FROM categories AS t1 INNER JOIN items AS t2 INNER JOIN product AS t3 ON t1.itemCode = t2.itemCode and t1.categoryCode = t3.categoryCode";
                            $jn1=getTableDataFromDB($s1);
                            //echo $jsn;
                            $jr1=json_decode($jn1);
                            
                            echo '<table id="tab">';
                            echo "<th>Item Code</th><th>Item Name</th><th>Category Name</th><th>Details</th><th>Details ID</th><th>Details of Category</th><th>";
                            foreach($jr1 as $table)
                            {
                                echo '<tr align="center">';
                                echo 
                                '<td>'.$table->itemCode.'</td><td>'.$table->itemName.'</td><td>'.$table->categoryName.'</td><td>'.$table->description.'</td>'.'</td><td>'.$table->productId.'</td>'.'</td><td>'.$table->categoryCode.'</td>';
                                echo '</tr>';
                            }
                            echo '</table>';                    
                        ?>
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