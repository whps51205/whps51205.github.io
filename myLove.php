<!DOCTYPE html>
<html lang = "en">
<head>
    <title>設為最愛</title>
<?php
    session_start();
    $getName = $_SESSION['thisRecipe'];
    $getId = $_SESSION['user'];
    include("dbconnect.php");
    $mysqli -> query('set names utf8');

    $repeatCheck = ("select * from 使用者 where (帳號 = '$getId') and (菜名ID = '$getName')");
    $get = $mysqli -> query($repeatCheck);
    $rows = $get -> num_rows;

    if($rows)
    {
        echo "<script>alert('已為最愛食譜');</script>";
        echo "<script>history.go(-1)</script>";
    }
    else
    {
        $Demand = $mysqli -> prepare("INSERT INTO 使用者(帳號,菜名ID) VALUES (?,?)");
        $Demand -> bind_param('si',$getId,$getName);
        if($Demand -> execute())
        {
            echo "<script>alert('成功加入最愛');</script>";
            echo "<script>history.go(-1)</script>";
            $Demand -> close();
        }
    }
    $mysqli -> close();
?>
</head>
<body></body>
</html>