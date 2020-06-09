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
            <link rel="stylesheet" href="./assets/css/reqForm.css">

            <!------------------------ FONT STYLES -------------------->
            <link href="https://fonts.googleapis.com/css?family=Bebas+Neue|PT+Sans|Poppins|Roboto+Mono|Nanum+Gothic&display=swap" rel="stylesheet">
            <!------------------------ JAVASCRIPT --------------------->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        </head>
        <script>
            $(document).ready(function()
            {
                $("#items").on('change',function(){
                    var itemId = $(this).val();
                    $.ajax({
                        method: "POST",
                        url: "dropDownHandle.php",
                        data: {id: itemId},
                        dataType: "html",
                        success:function(data){
                            $("#category").html(data);
                        }
                    })
                });

                $("#category").on('change',function(){
                    var catId = $(this).val();
                    $.ajax({
                        method: "POST",
                        url: "dropDownHandle.php",
                        data: {cId: catId},
                        dataType: "html",
                        success:function(data){
                            $("#details").html(data);
                        }
                    })
                })

            })


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
                <div class="bodySec" id="bodySec" style="z-index: 1;">
                    <div class="column" id="addForm" style="z-index: 1;">
                        
                        <form class="reqForm" action="./requisitionForm.php" method="post">
                            <div class="dash-titles">Add Requisition</div>
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

                            <select name="category" id="category">
                                <option  value="">Select Category</option>
                            </select><br>
                            <select name="details" id="details">
                                <option value="">Select Details</option>
                            </select><br>
                            <input type="text" name="quantity" id="quantity" placeholder="Input Quantity"><br>
                            
                            <select name="units" id="units">
                                <option  value="">Select Unit</option>
                                <?php
                                    $i2 = "SELECT * from units";
                                    $json2 = getJSONFromDB($i2);
                                    $decJs2 = json_decode($json2);
                                    
                                    foreach($decJs2 as $v2)
                                    {
                                        echo "<option value='$v2->unit_details'>".$v2->unit_details."</option>";
                                    }
                                    
                                ?>
                            </select><br>
                            
                            <input type="text" name="Rate" id="Rate" placeholder="Input Rate"><br>
                            
                            <input type="text" name="Note" id="Note" placeholder="Input Note"><br>
                            <input type="submit" name="Submit" id="Submit" value="ADD">
                        </form>
                        <?php
                            if(isset($_POST['Submit']))
                            {
                                if(!empty($_POST['items']) && !empty($_POST['category']) && !empty($_POST['details']) && !empty($_POST['quantity']) && !empty($_POST['units']) && !empty($_POST['Rate']))
                                {

                                    $rItem = $_POST['items'];
                                    $rCat = $_POST['category'];
                                    $rDet = $_POST['details']; 
                                    $rQuan = $_POST['quantity'];
                                    $rUnit = $_POST['units'];
                                    $rRate = $_POST['Rate'];
                                    $rNote = $_POST['Note'];
                                    $rAmount = ($rQuan*$rRate);


                                    if(isset($_SESSION['requisition_cart']))
                                    {
                                        $item_array_id = array_column( $_SESSION['requisition_cart'], 'sItem');
                                        
                                        $count = count($_SESSION['requisition_cart']);
                                        $item_array = array(
                                            'sItem' => $rItem,
                                            'sCat' => $rCat,
                                            'sDet' => $rDet,
                                            'sUnit' => $rUnit,
                                            'sQuan' => $rQuan,
                                            'sRate' => $rRate,
                                            'sAmount' => $rAmount,
                                            'sNote' => $rNote
                                        );
                                        $_SESSION['requisition_cart'][$count] = $item_array ;
                                    }
                                    else{
                                        $item_array = array(
                                            'sItem' => $rItem,
                                            'sCat' => $rCat,
                                            'sDet' => $rDet,
                                            'sUnit' => $rUnit,
                                            'sQuan' => $rQuan,
                                            'sRate' => $rRate,
                                            'sAmount' => $rAmount,
                                            'sNote' => $rNote
                                        );
                                        $_SESSION['requisition_cart'][0] = $item_array ;
                                    }                                
                                    
                                    echo "<h5 style='color:green;'>Added</h5>";
                                    header("Refresh:0; url=requisitionForm.php");
                                }
                                else
                                {
                                    echo '<h6 style="color:red;">Field is empty</h6>';
                                }
                            }
                        ?>
                    </div>      
                    <div class="column" id="reqList" style="z-index: 1;">
                        <div class="dash-titles"o>Requisition History</div>
                        <form class="requisition-table" action="./requisitionForm.php" method="post">
                            <table id="req-tab-data">
                                <tr>
                                    <th>SN</th><th>Item Name</th><th>Category</th><th>Details</th><th>Unit</th><th>Quantity</th><th>Rate</th><th>Amount</th><th>Remarks</th><th>Update</th><th>Delete</th>
                                </tr>
                                <?php
                                    $sn = 1; $i = 0; $c = 0; $d = 0; $u = 0; $q = 0; $r = 0; $am = 0; $re = 0;
                                        echo "<tr>";
                                        if(!empty($_SESSION['requisition_cart']))
                                        {
                                            $total =0;
                                            $sn = 1;
                                            $c = 0;

                                            // print_r($_SESSION['requisition_cart'][$sn]);
                                            // echo "<pre>";

                                            foreach($_SESSION['requisition_cart'] as $keys => $values)
                                            {
                                                // print_r($keys);
                                                // print_r($values);
                                                echo "<tr>";
                                                    echo "<td>".$sn++."</td>";
                                                    echo "<td>".$values['sItem']."</td>";
                                                    echo "<td>".$values['sCat']."</td>";
                                                    echo "<td>".$values['sDet']."</td>";
                                                    echo "<td>".$values['sUnit']."</td>";
                                                    echo "<form action='./requisitionForm.php' method='post'>";
                                                        echo '<td><input name="quan" id="quan" value="';
                                                        echo $values['sQuan'].'"></td>';
                                                        echo '<td><input name="rate" id="rate" value="';
                                                        echo $values['sRate'].'"></td>';
                                                    echo "<td>".$values['sAmount']."</td>";
                                                    echo "<td>".$values['sNote']."</td>";
                                                        echo "<td><input type='submit' name='event' id='update' value='Update'></td>";
                                                        echo "<td><input type='submit' name='event' id='delete' value='Delete'></td>"; 
                                                        echo "<input type='hidden' name='hiddenKey' value='".$keys."'>";
                                                    echo "</form>";

                                                echo "</tr>";
                                                $total = $total + $values['sAmount'];

                                                $c++;
                                                // print_r($pId);
                                            }
                                            echo "<tr id='tot'>";
                                            echo "<td id='' colspan='6'></td>";
                                            echo "<td id='total' >TOTAL:</td>";
                                            echo "<td id='total-val'>".$total."</td>";
                                            echo "</tr>";
                                        }                            
                                ?>                            
                            </table>
                            <input type="submit" name='addReq' id="addReqBut" value="Submit Requisition">
                        </form>
                        <?php
                        
                            if(isset($_POST['event']))
                            {
                                $hKey = $_POST['hiddenKey'];
                                $event = $_POST['event'];
                                $hQuan = $_POST['quan'];
                                $hRate = $_POST['rate'];
                                if ($event == "Update")
                                {
                                    // echo $hKey;
                                    foreach($_SESSION['requisition_cart'] as $keys => $values)
                                    {                                   
                                        // echo $keys;
                                        if($keys == $hKey)
                                        {
                                            // print_r($_SESSION['requisition_cart'][$keys]['sQuan']);
                                            $_SESSION['requisition_cart'][$keys]['sQuan']= $hQuan;
                                            $_SESSION['requisition_cart'][$keys]['sRate']= $hRate;
                                            $_SESSION['requisition_cart'][$keys]['sAmount'] = ($hQuan*$hRate);
                                        }
                                    }
                                    
                                    header("Refresh:0; url=requisitionForm.php");
                                }
                                else if ($event == "Delete")
                                {
                                    // echo $hKey;
                                    foreach($_SESSION['requisition_cart'] as $keys => $values)
                                    {                                   
                                        // echo $keys;
                                        if($keys == $hKey)
                                        {
                                            unset($_SESSION['requisition_cart'][$keys]);
                                        }
                                    }
                                    
                                    header("Refresh:0; url=requisitionForm.php");
                                }
                            }

                            else if (isset($_POST['addReq']))
                            {
                                if(!empty($_SESSION['requisition_cart']))
                                {

                                    
                                    $rUname = $uid;
                                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka')); 
                                    $time =  $dt->format('F j, Y g:i a');
                                    $rUptime= $time;
                                    $rStatus= '0';

                                    $req_sql = " INSERT INTO `req_offer`(`prefix`, `r_id`, `r_uname`, `r_uptime`, `r_status`) VALUES ('REQ','','$rUname','$rUptime','$rStatus') ";

                                    echo $req_sql;

                                    require('./dbConnect.php');
                                    $result = mysqli_query($conn, $req_sql); 
                                    $req_order = mysqli_insert_id($conn);
                                    echo "<div style='color:red;'>".$req_order."</div>";

                                    foreach($_SESSION['requisition_cart'] as $keys => $values)
                                    {
                                        $id='1';
                                        $rItem = $values['sItem'];
                                        $rCat = $values['sCat'];
                                        $rDet = $values['sDet'];
                                        $rQuan = $values['sQuan'];
                                        $rUnit = $values['sUnit'];
                                        $rRate = $values['sRate'];
                                        $rRemark= $values['sNote'];
                                        

                                        $req_items_sql = " INSERT INTO `req_offer_items`(`req_order_id`,`req_Id`, `req_item`, `req_cat`, `req_det`, `req_quan`, `req_unit`, `req_rate`, `req_remark`, `req_uname`, `req_upTime`, `req_status`) VALUES ('$req_order', '$id', '$rItem', '$rCat', '$rDet', '$rQuan', '$rUnit', '$rRate', '$rRemark' , '$rUname', '$rUptime', '$rStatus' )";

                                        // echo "<br><br>".$req_sql;
                                        
                                        require('./dbConnect.php');
                                        $result = mysqli_query($conn, $req_items_sql); 

                                        if (!$result) {
                                        printf("Errormessage: %s\n", mysqli_error($conn));
                                        }
                                        
                                    
                                        
                                        echo "<h5 style='color:green;'>Added</h5>";
                                    }
                                    $id++;
                                    require('./dbConnect.php');
                                    $conn->close();
                                    echo "<script style='color:green;'>alert('Added')</script>";
                                    unset($_SESSION['requisition_cart']);
                                    header("Refresh:0; url=requisitionForm.php");
                                }      
                                else{
                                    echo "<script>alert('Cart Is Empty')</script>";
                                }
                            }
                        
                        ?>
                    </div>          
                </div>
            </div>
            
        </body>
        </html>

    <?php

        }
    }

    ?>