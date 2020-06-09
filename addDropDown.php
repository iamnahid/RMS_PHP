<?php

    require("./dbConnect.php");
  

   // ----------------  ADD ITEM PAGE  ------------------------
    if (isset($_POST['aId']))
    {
        $addId = $_POST['aId'];
        function getJSONFromDB($sql)
        {
            require("./dbConnect.php");
            $result = mysqli_query($conn, $sql)or die(mysqli_error());
            $arr=array();
            while($row = mysqli_fetch_assoc($result)) {
                $arr[]=$row;
            }
            return json_encode($arr);
        }
        $addSql = "SELECT * from categories where itemCode = '$addId'";
        // echo "<option value='$v1->categoryCode'>".$addId."</option>";

        $json1 = getJSONFromDB($addSql);
        $decJs1 = json_decode($json1);
        
        foreach($decJs1 as $v1)
        {
            echo "<option>".$addSql."</option>";
        }

    }



?>