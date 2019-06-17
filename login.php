<!DOCTYPE html>

<html lang = "en">
<head>
    <meta charset = "utf-8">

    <title>為食而行-登入使用者帳號</title>

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

        table
        {
            font-family: DFKai-sb;
            font-size: 30px;
        }
        .text
        {
            font-size: 30px;
        }
        input::-webkit-input-placeholder
        {
            color: #aab2bd;/* placeholder颜色  */
            font-size: 20px;/* placeholder字體大小  */
        }
    </style>
</head>

<body>
<header>
    <span class="set"></span>
</header>
<h1 class = "title">為食而行</h1>

<ul style = "right: 15%">
    <a href = "user.php">
        <li class = "option">首頁</li>
    </a>
    <a href = "standard.php">
        <li class = "option">國家健康標準</li>
    </a>

    <a href = "login.php">
        <li class = "option">登錄</li>
    </a>

    <a href = "register.php">
        <li class = "option">註冊</li>
    </a>
</ul>

<img class = "img" src = "封面1.png" alt="">

<form action = "login.php" method = "post">
    <table border = "1" align = "center">
        <caption style = "display: inline;margin-left: 10px">
            使用者登入
            <span id = "show" style="color: red;padding-left: 5em"></span>
        </caption>

        <tr>
            <td style = "border-style: none">帳號：<input class = "text" type = "text" size = "50" placeholder= "Your Id" name = "users_id" style = "padding: 5px 20px;margin: 10px" required></td>
        </tr>
        <tr>
            <td style = "border-style: none">密碼：<input class = "text" type = "password" size = "50" placeholder="password" name = "password" style = "padding: 5px 20px;margin: 10px" required></td>
        </tr>
        <tr>
            <td style = "border-style: none">
                <input type = "submit" value = "登入" style = "font-size: 30px;font-weight: bold;font-family: DFKai-sb;color: white;background-color: lightskyblue;height: 50px;width: 100%">
            </td>
        </tr>
    </table>
</form>
</body>
</html>
<?php
session_start();
if(isset($_POST['users_id']) && isset($_POST['password']))
{
    include("dbconnect.php");
    $mysqli -> query('set names utf8');
    $id = $_POST['users_id'];
    $pd = $_POST['password'];
    $md5pd = md5($pd);

    $login = ("select * from 帳密 where (帳號 = '$id') and (密碼 = '$md5pd')");
    $check = $mysqli -> query($login);
    $rows = $check -> num_rows;

    if($rows)
    {
        $_SESSION['user'] = $id;           // 取得使用者ID
		if ($id == "root")
		{
			header('location:root.php');
		}
		else
			echo "<script>"."alert('Hello!  $id');"."location.href = 'user.php';"."</script>";
    }
    else
    {
        echo "<script>"."document.getElementById('show').innerHTML = \"使用者名稱或密碼錯誤!\" ;"."</script>";
    }
    $mysqli -> close();
}



