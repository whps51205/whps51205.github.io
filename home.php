<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "utf-8">
    <title>為食而行-首頁</title>
    <link rel="stylesheet" type = text/css href="style.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.9.1.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src = "searchbox.js"></script>
    <link rel="stylesheet" href="searchbox.css">
</head>

<body>
    <header>
        <span class="set"></span>
    </header>

    <h1 class = "title">為食而行</h1>

    <ul style = "right: 15%">
        <li id = "checkIfLogin"></li>

        <a href = "loginOut.php">
            <li class = "option" id = "loginOut" style="display: none">登出</li>
        </a>
        <a href = "login.php">
            <li class = "option" id = "loginIn">登入</li>
        </a>
        <a href = "register.php">
            <li class = "option" id = "register">註冊</li>
        </a>
        <a href = "standard.php">
            <li class = "option">國家健康標準</li>
        </a>
        <a href = "lookMyLove.php">
            <li class = "option" id = "lookMyLove" style="display: none">我的最愛</li>
        </a>
        <a href = "#">
            <li class = "option" onclick="getClick()">精確搜尋</li>
        </a>
        <a href = "#1">
            <li class = "option" onclick="getClickTwo()">按類型搜尋</li>
        </a>
		
		<a href = "root.php">
            <li style = "display: none;"class = "option" id = "root">管理</li>
		</a>
    </ul>
    <img class = "img" src = "封面1.png" alt="">

    <form action = "searchResult.php" method = "post">
        <input class = "search" type = "submit" value = "搜尋">
        <input class = "searchBox" type = "text" name = "searchName" size = "40" maxlength ="20" placeholder="搜尋食譜名稱" required>
    </form>

    <form action = "searchResultTwo.php" method = "post">
        <div class="searchBoxTwo" id="searchTwo" style="display: none">
            <select id="combobox" name = "searchName">
                <option></option>
            </select>
            <br>
            <input  type = "submit" value = "精確搜尋">
        </div>
    </form>
    <form action = "SearchType.php" method = "post">
        <div class="searchBoxTwo" id="searchThree" style="display: none">
            <select id="comboboxTwo" name = "typeName">
                <option></option>
            </select>
            <br>
            <input  type = "submit" value = "按類別搜尋">
        </div>
    </form>
</body>
</html>
<?php
session_start();
if(isset($_SESSION['user']))
{
    $getName = $_SESSION['user'];
    echo "<script>"."document.getElementById('checkIfLogin').innerHTML = \"您好, $getName\";" ."</script>";
    echo "<script>"."document.getElementById('loginIn').style.display = \"none\";" ."</script>";
    echo "<script>"."document.getElementById('register').style.display = \"none\";" ."</script>";
    echo "<script>"."document.getElementById('lookMyLove').style.display = \"table-cell\";" ."</script>";
    echo "<script>"."document.getElementById('loginOut').style.display = \"table-cell\";" ."</script>";
	if ($getName == "root")
	{
		echo "<script>"."document.getElementById('root').style.display = \"table-cell\";" ."</script>";
	}
}
else
{
    echo "<script>"."document.getElementById('checkIfLogin').innerHTML = \"您尚未登入!\";" ."</script>";
}

include("dbconnect.php");
$mysqli->query('set names utf8');
$getchose = ("select * from 食譜");
$get = $mysqli->query($getchose);
$Arr = array();
$Count = 1;
while ($rows = mysqli_fetch_array($get)) {
    $Arr[$Count] = $rows['菜名'];
    $Count++;
}
for ($i = 1; $i < count($Arr) + 1; $i++) {
    echo "<script type=\"text/javascript\">";
    echo "document.getElementById(\"combobox\").options[$i]=new Option(\"$Arr[$i]\",\"$Arr[$i]\");";
    //new Option(text,value)
    echo "</script>";
}

$getchose = ("select DISTINCT 食譜類型 from 食譜類型");
$get = $mysqli -> query($getchose);
$ArrT = array();
$Counter = 1;
while($rows=mysqli_fetch_array($get))
{
    $ArrT[$Counter]=$rows['食譜類型'];
    $Counter++;
}
for($i=1;$i<count($ArrT)+1;$i++)
{
    echo "<script type=\"text/javascript\">";
    echo "document.getElementById(\"comboboxTwo\").options[$i]=new Option(\"$ArrT[$i]\",\"$ArrT[$i]\");";
    echo "</script>";
}
?>

