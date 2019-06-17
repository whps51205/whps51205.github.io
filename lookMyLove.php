<!DOCTYPE html>
<html lang = "en">
<head>
	<title>我的最愛</title>
<?php
	include ("home.php");
	include("dbconnect.php");
	$userid = ($_SESSION['user']);
	echo "<div class = 'frame' style = 'width: 50%;margin-top: 10px;'><center><table class = 'myLove'>";
	echo "<thead><tr><td colspan = '2'>"."您";
	echo "的最愛：</td></tr></thead>";
	
	$mysqli -> query('set names utf8');
	$input = "select * from 使用者 as a, 食譜 as b where (a.菜名ID=b.菜名ID) and (a.帳號 ='$userid') ";
  	$check = $mysqli -> query($input);
	echo "<tbody>";
  	while($result = $check->fetch_object())
    {
        echo '<tr><td><a href=recipe.php?recipe="'.$result -> 菜名.'">'.$result -> 菜名.'</a></td>';
        echo '<td><a href=lookMyLove.php?deleteID="'.$result -> 菜名ID.'">'.'<input type="button" value="刪除" style = "cursor: pointer;">'.'</a></td></tr>';
    }
	echo "</tobdy></table></center></div>";

    $mysqli -> query('set names utf8');

    if(!isset($_GET["deleteID"]))
    {
        $deleteID = '';
    }
    else
    {
        $deleteID = $_GET["deleteID"];

        $input = "delete from 使用者 where 使用者.帳號 = '$userid' and 使用者.菜名ID = $deleteID";
        $delete = $mysqli -> query($input);

        $input = "select * from 食譜 where 菜名ID = $deleteID";
        $set = $mysqli ->query($input);
        while($getName = $set->fetch_object())
        {
            $recipe = $getName -> 菜名;
        }
        echo "<script>alert('已將 $recipe 至您的最愛移除!');location.href = 'lookMyLove.php';</script>";
    }
?>
</head>
<body></body>
</html>