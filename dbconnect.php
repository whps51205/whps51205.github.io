<?php
    $mysqli = new mysqli('localhost','root','12345678','dbfinal');
    if($mysqli->connect_error)
    {
        die('連結錯誤訊息: '. $mysqli->connect_error."<br>");
    }