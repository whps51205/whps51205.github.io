<?php
    session_start();
    $getKcal = $_SESSION['thisKcal'];                   //取得該食譜的卡路里
    $getNum = $_POST['number'];                         //取得份量
    $_SESSION['kcal'] += $getKcal * $getNum;            //累加總卡路里
    $_SESSION['chose'] = $_SESSION['chose'] . $_SESSION['recipe'] . $getNum ."份<br>"; //chose為記錄已選擇食譜的全域變數
    $getName = $_SESSION['recipe'];
    echo "<script>alert('選擇了$getName $getNum 份'); location.href = history.back();</script>";
