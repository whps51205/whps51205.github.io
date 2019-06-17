<?php
	include("dbconnect.php");
    $mysqli -> query('set names utf8');
	session_start();
	if(!isset($_SESSION['user']))
	{
		echo "<script>alert('您已登出!');</script>";
        echo "<script>history.go(-1)</script>";
		exit();
	}
?>

<!DOCTYPE html>

<html lang = "en">
<head>
    <meta charset = "utf-8">
    <title>為食而行-管理者介面</title>

    <style type = "text/css">
        header
        {
            position: relative;
            width: 100%;
        }
        .set
        {
            background-color: black;
            opacity: 0.6;
            width: 100%;
            height: 50px;
            position: absolute;
            z-index: 1;
        }

        .title
        {
            font-family: DFKai-sb;
            font-size: 60px;
            color: white;
            position: absolute;
            left: 5%;
            margin-top: 50px;
            z-index: 1;
        }

        .img
        {
            position: relative;
            width: 100%;
            -webkit-filter: brightness(.5);
        }

        .option
        {
            font-weight: bold;
            font-size: 15px;
            border: 5px lightskyblue solid;
            display: inline-block;
            padding: 2px;
            background-color: lightskyblue;
        }

        ul
        {
            font-family: DFKai-sb;
            list-style: none;
            color: white;
            position: absolute;
            z-index: 1;
        }

        ul li
        {
            display: inline;
        }

        a
        {
            color: white;
            text-decoration: none;
        }

    </style>
    <script type="text/javascript">
        function addRecipe()
        {
            document.getElementById('addRecipe').style.display = "inline";
            document.getElementById('deleteRecipe').style.display = "none";
            document.getElementById('deleteUser').style.display = "none";
        }
        function deleteRecipe()
        {
            document.getElementById('deleteRecipe').style.display = "inline";
            document.getElementById('addRecipe').style.display = "none";
            document.getElementById('deleteUser').style.display = "none";
        }
        function deleteUser()
        {
            document.getElementById('deleteUser').style.display = "inline";
            document.getElementById('addRecipe').style.display = "none";
            document.getElementById('deleteRecipe').style.display = "none";
        }
    </script>
</head>
<body>
    <header>
        <span class="set"></span>
    </header>
<h1 class = "title">為食而行-管理者介面</h1>
    <ul style = "right: 15%">
        <a href = "user.php">
            <li class = "option">首頁</li>
        </a>
		
		<a href = "loginOut.php">
            <li class = "option">離開</li>
        </a>
		
        <a href = "#">
            <li class = "option"  onclick="addRecipe()">新增食譜</li>
        </a>
        <a href = "#">
            <li class = "option"  onclick="deleteRecipe()">刪除食譜</li>
        </a>
        <a href = "#">
            <li class = "option"  onclick="deleteUser()">刪除使用者帳號</li>
        </a>
    </ul>
    <img class = "img" src = "封面1.png" alt="">
<div style="display: none" id = "addRecipe">
        <form action = "#" method = "post">新增食譜
            <p>食譜名: <input type = text maxlength="19" name = "Name" required></p>
            <p>食譜類型:
                <select name="Type">
                    <option value="主菜">主菜</option>
                    <option value="早餐">早餐</option>
                    <option value="前菜">前菜</option>
                    <option value="甜點">甜點</option>
                </select>
            </p>
            <p>每100公克之熱量：<input type = text maxlength="5" name = "Cal" required></p>
            <p>作法：<br><textarea maxlength="500" name = "Step" rows="25" cols="60" required></textarea></p>
            <p><input type = "submit" value = "新增"></p>
        </form>
</div>
    <div style="display: none" id = "deleteRecipe">
        <form action = "#" method = "post">刪除食譜
            <p>食譜名: <input type = text maxlength="19" name = "deleteName" required></p>
            <p><input type = "submit" value = "刪除"></p>
        </form>
    </div>
    <div style="display: none" id = "deleteUser">
        <form action = "#" method = "post">刪除使用者帳號
            <p>使用者帳號: <input type = text maxlength="10" name = "deleteUser" required></p>
            <p><input type = "submit" value = "刪除"></p>
        </form>
    </div>
</body>

<?php
if(isset($_POST['Name']) && isset($_POST['Type']) && isset($_POST['Cal']) && isset($_POST['Step']))
{
    include("dbconnect.php");
    $mysqli -> query('set names utf8');
    $name = $_POST['Name'];
    $type = $_POST['Type'];
    $cal = $_POST['Cal'];
    $step = $_POST['Step'];

    $repeatCheck = "select 菜名 from 食譜 where (菜名 = '$name')";
    $get = $mysqli -> query($repeatCheck);
    $rows = $get -> num_rows;
    if($rows)
    {
        echo "<script>alert('已有此道菜!');</script>";
        echo "<script>history.go(-1)</script>";
    }
    else
    {
        $Demand = $mysqli -> prepare("INSERT INTO 食譜類型(菜名,食譜類型) VALUES (?,?)");
        $Demand -> bind_param('ss',$name,$type);         //ss為字串型態
        if($Demand -> execute())
        {
            $Demand -> close();
        }
        $Demand = $mysqli -> prepare("INSERT INTO 食譜(菜名,熱量,作法) VALUES (?,?,?)");
        $Demand -> bind_param('sds',$name,$cal,$step);         //ss為字串型態
        if($Demand -> execute())
        {
            echo "<script>alert('新增成功!');</script>";
            echo "<script>history.go(-1)</script>";
            $Demand -> close();
        }
    }
    $mysqli -> close();
}?>
<?php
    include("dbconnect.php");
    $mysqli -> query('set names utf8');
    if(isset($_POST['deleteName']))
    {
        $deleteName = $_POST['deleteName'];
        $Check = "select 菜名 from 食譜類型 where (菜名 = '$deleteName')";
        $get = $mysqli -> query($Check);
        $rows = $get -> num_rows;
        if(!$rows)
        {
            echo "<script>alert('無此道菜!');</script>";
            echo "<script>history.go(-1)</script>";
        }
        else
        {
            $deleteDemand = "delete from 食譜類型 where 菜名 = '$deleteName'";
            $delete = $mysqli -> query($deleteDemand);
            echo "<script>alert('刪除成功!');</script>";
            echo "<script>history.go(-1)</script>";
        }
    }
?>
<?php
include("dbconnect.php");
$mysqli -> query('set names utf8');
if(isset($_POST['deleteUser']))
{
    $deleteUser = $_POST['deleteUser'];
    $Check = "select 帳號 from 帳密 where (帳號 = '$deleteUser')";
    $get = $mysqli -> query($Check);
    $rows = $get -> num_rows;
    if(!$rows)
    {
        echo "<script>alert('無此帳號!');</script>";
        echo "<script>history.go(-1)</script>";
    }
    else
    {
        $deleteDemand = "delete from 帳密 where 帳號 = '$deleteUser'";
        $delete = $mysqli -> query($deleteDemand);
        echo "<script>alert('刪除成功!');</script>";
        echo "<script>history.go(-1)</script>";
    }
}
?>
