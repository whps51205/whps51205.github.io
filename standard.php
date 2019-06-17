<!DOCTYPE html>
<html lang = "en">
<head>
    <title>國家健康標準</title>
<?php
    include("dbconnect.php");
	include ("home.php");
    $mysqli -> query('set names utf8');
    $sql = "select * from 國家健康標準";
    $get = $mysqli -> query($sql);
    echo "<center><table class = 'standard'><thead>";
    echo "<tr><td><b>年齡應攝取量</b></td>";
    echo "<td><b>全榖雜糧類</b></td>";
    echo "<td><b>豆魚肉蛋類</b></td>";
    echo "<td><b>乳品類</b></td>";
    echo "<td><b>蔬菜類</b></td>";
	echo "<td><b>水果類</b></td>";
	echo "<td><b>油脂與堅果種子類</b></td></tr></thead>";
	echo "<tbody>";
    while($result = mysqli_fetch_row($get))
    {
        echo "<tr><td>".$result[0]."</td>";
        echo "<td>".$result[1]."</td>";
        echo "<td>".$result[2]."</td>";
        echo "<td>".$result[3]."</td>";
        echo "<td>".$result[4]."</td>";
		echo "<td>".$result[5]."</td>";
		echo "<td>".$result[6]."</td></tr>";
    }
	echo "</tbody></table></center>";
    $mysqli -> close();
?>
</head>
<body>
    <input class = "inputStd" type="button" value="回上頁" onclick="history.back()">
</body>
</html>