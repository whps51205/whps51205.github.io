<?php // 結算已選擇食譜
    session_start();
    include("dbconnect.php");
    $mysqli -> query('set names utf8');
    $weight = $_POST['weight'];     //取得體重
    $sportWay = $_POST['sport'];    //取得運動方式
    if($sportWay == '選擇運動方式')
    {
        echo "<script>alert('請輸入運動方式!');</script>";
        echo "<script>history.go(-1)</script>";
        exit();
    }
    $totalKcal = $_SESSION['kcal'];
    $input = "select * from 運動 where 運動方式 = '$sportWay'";
    $a = $mysqli->query($input);
    while($result = $a ->fetch_object())
    {
        echo  $result -> 運動方式;
        $temp =  $weight*($result -> 消耗熱量) ;
        echo "需運動" . round($totalKcal/$temp,2) ."小時";
        echo '<input type = button value="回上頁" onclick="history.go(-1)">';
    }


