<?php

    require("./dbConnect.php");

    

    if (isset($_POST['id']))
    {
        $id = $_POST['id'];
        function getJSONFromDB($sql)
        {
            require("./dbConnect.php");
            $result = mysqli_query($conn, $sql)or die(mysqli_error());
            $arr=array();
            while($row = mysqli_fetch_assoc($result)) {
                $arr[]=$row;
                // echo $row["name"];echo $row["id"];echo "<br>";
            }
            return json_encode($arr);
        }
        $i1 = "SELECT * from categories where itemCode = '$id'";
        $json1 = getJSONFromDB($i1);
        $decJs1 = json_decode($json1);
        
        foreach($decJs1 as $v1)
        {
            echo "<option value='$v1->categoryCode'>".$v1->categoryName."</option>";
        }

    }


    if (isset($_POST['cId']))
    {
        $id = $_POST['cId'];
        function getJSONFromDB($sql)
        {
            require("./dbConnect.php");
            $result = mysqli_query($conn, $sql)or die(mysqli_error());
            $arr=array();
            while($row = mysqli_fetch_assoc($result)) {
                $arr[]=$row;
                // echo $row["name"];echo $row["id"];echo "<br>";
            }
            return json_encode($arr);
        }
        $i1 = "SELECT * from product where categoryCode = '$id'";
        $json1 = getJSONFromDB($i1);
        $decJs1 = json_decode($json1);
        
        foreach($decJs1 as $v1)
        {
            echo "<option value='$v1->productId'>".$v1->description."</option>";
        }

    }

    // // ----------------  ADD ITEM PAGE  ------------------------
    // if (isset($_POST['id']))
    // {
    //     $id = $_POST['id'];
    //     function getJSONFromDB($sql)
    //     {
    //         require("./dbConnect.php");
    //         $result = mysqli_query($conn, $sql)or die(mysqli_error());
    //         $arr=array();
    //         while($row = mysqli_fetch_assoc($result)) {
    //             $arr[]=$row;
    //             // echo $row["name"];echo $row["id"];echo "<br>";
    //         }
    //         return json_encode($arr);
    //     }
    //     $i1 = "SELECT * from categories where itemCode = '$id'";
    //     $json1 = getJSONFromDB($i1);
    //     $decJs1 = json_decode($json1);
        
    //     foreach($decJs1 as $v1)
    //     {
    //         echo "<option value='$v1->categoryCode'>".$v1->categoryName."</option>";
    //     }

    // }





?>