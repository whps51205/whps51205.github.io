<!DOCTYPE html>
<html lang="en">
<head>
    <title>食譜介紹</title>
</head>
<body>
<?php
    include("dbconnect.php");
    include ("home.php");
    $mysqli -> query('set names utf8');
    $recipe = $_GET["recipe"];                          //取得點擊食譜名
    $input = "select * from 食譜 where 菜名 = $recipe";
    $check = $mysqli -> query($input);
    $cal="熱量";

    echo '<center><table>';
    while($result = $check->fetch_object())
    {
        $_SESSION['recipe'] = $result -> 菜名;          //取得這個食譜的菜名   存入全域recipe變數
        $_SESSION['thisRecipe'] = $result -> 菜名ID;    //取得這個食譜的菜名ID 存入全域thisRecipe變數
        echo '<thead><tr><td>';
        echo $result -> 菜名.'</td></tr></thead>';
        echo "<tbody><tr><td class = 'detail'>熱量:<br>";
        echo "每100公克";
        echo $result -> $cal."大卡</td>";
        $thisRecipeKcal = $result -> $cal;
        $_SESSION['thisKcal'] = $thisRecipeKcal;        //取得這個食譜的卡路里 存入全域thisKcal變數
        if(!isset($_SESSION['kcal']))                   //判斷熱量計數器是初始化
        {
            $_SESSION['kcal'] = $thisRecipeKcal;        //無 -> 總熱量計數器 = 這個食譜的卡路里
        }
        echo "<tr><td class = 'detail'>作法:<br>";
        echo nl2br($result -> 作法.'<br>');       //nl2br換行
        echo "</td></tr>";
        echo "<tr><td class = 'detail'>所需材料:<br>";
    }

    $input = "select 食材,數量 from 食材 as a, 備料 as b, 食譜 as c 
                where (a.食材編碼=b.食材編碼ID) and (b.菜名ID=c.菜名ID) and (c.菜名 = $recipe)";
    $check = $mysqli -> query($input);                  //取得該食譜的食材及數量

    while($getPrepare = $check->fetch_object())
    {
        echo  $getPrepare-> 食材;
        echo  $getPrepare-> 數量.'<br>';
    }
    if(!isset($_SESSION['chose']))                      //chose為記錄已選擇食譜的全域變數
    {
        $_SESSION['chose'] = '您已選擇的食譜: <br>';     //初始化
    }
    $record = $_SESSION['chose'];
    echo '<form style = "display: inline-block;"method="post" action="counter.php">     
                <input type = "number" name = "number" placeholder="輸入所需份量" min="1.000000000" max="99" required>
                <input type= "submit" value="確定">';
    echo "</form>";
    /*-------------*/
    echo '<form style = "margin-left: 10px;display: inline-block;"method="post" action="delete.php">     
                <input type= "submit" value="刪除已選擇食譜"><br>';
    echo "</form><br>";
    /*-------------*/
    echo $record;
    echo '<form method="post" action="kcal.php">
                <input type = "number" name="weight" placeholder="輸入您的體重" min="1.000000000" max="999" required>
                    <select id = "bottom" name = "sport">
                        <option>選擇運動方式<option>
                    </select>
                <input type= "submit" value="結算已選擇食譜">';
    echo '</form>';

    echo '</td></tr></tbody></table></center>';                  //21 及 33行之結束
    ?>

    <?php  //運動方式下拉式選單
    $getchose = ("select DISTINCT 運動方式 from 運動");
    $get = $mysqli -> query($getchose);
    $Arr = array();
    $Count = 1;
    while($rows=mysqli_fetch_array($get))
    {
        $Arr[$Count] = $rows['運動方式'];
        $Count++;
    }
    for($i=1;$i<count($Arr)+1;$i++)
    {
        echo "<script type=\"text/javascript\">";
        echo "document.getElementById(\"bottom\").options[$i]=new Option(\"$Arr[$i]\",\"$Arr[$i]\");";
                                                            //new Option(text,value)
        echo "</script>";
    }
    echo'
    <form action="myLove.php" method="post">
        <div style = "display: inline-block;"><a href = "user.php"><input type="button" value="回到首頁"></a></div>
        <input type="submit" value="設為最愛" style="display: none"	 id = "myLove" name="addToLove">
    </form>
   ';
    ?>
    <?php
    if(isset($_SESSION['user']))          //登入才能加為最愛
    {
        echo "<script>"."document.getElementById('myLove').style.display = \"inline\";" ."</script>";
    }
    ?>
</body>
</html>

