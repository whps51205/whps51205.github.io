<?php
session_start();
unset($_SESSION['users_id']);
unset($_SESSION['user']);
unset($_SESSION['thisRecipe']);
unset($_SESSION['recipe']);
unset($_SESSION['thisKcal']);
unset($_SESSION['kcal']);
unset($_SESSION['chose']);
unset($_SESSION['searchKeyWord']);
session_destroy();

echo "<script>alert('登出成功! 按確認回到首頁'); location.href = 'user.php';</script>";


