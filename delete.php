<?php
    session_start();
    unset($_SESSION['chose']);
    $_SESSION['kcal'] = 0;
    echo "<script>alert('刪除了已選擇食譜');</script>";
    echo "<script>history.go(-1)</script>";