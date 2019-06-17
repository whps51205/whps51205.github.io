
<?php
include("dbconnect.php");
include("home.php") ;
$mysqli -> query('set names utf8');
if(!isset($_POST['typeName'])) // other
{
    $_POST['typeName'] = $_SESSION['searchByType'];
    $ss = $_POST['typeName'];
    $get = "select * from 食譜類型 where 食譜類型 = '$ss'";//?
    $data = $mysqli ->query($get);
    $number= 5 ;//每次要顯示幾筆資料
    $total = mysqli_num_rows($data);//總共有幾筆資料
    $pages = ceil($total/$number);//透過無條件進位法，算出需要幾頁
}
else // first
{
    $inputName = $_POST['typeName'];
    $get = "select * from 食譜類型 where 食譜類型 = '$inputName'";
    $data = $mysqli ->query($get);
    $number = 5 ;//每次要顯示幾筆資料
    $total = mysqli_num_rows($data);//總共有幾筆資料
    $pages = ceil($total/$number);//透過無條件進位法，算出共需要幾頁
    $_SESSION['searchByType'] = $inputName;
}

if(!isset($_GET['p']))
{
    $p=1;
    $_SESSION['getP'] = $p;
}
else
{
    $p = $_GET['p'];
}

//用來呈現資料
$s = $_SESSION['searchByType'];
$start=($p-1)*$number;
$set = "select * from 食譜類型 where 食譜類型  = '$s' limit $start , $number";
$data = $mysqli ->query($set);
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset=utf-8" >
    <title>根據資料筆數顯示</title>
</head>

<body>

    <?php
    echo '<center><div class = "frame"><table>';
    echo '<thead><tr>';
    echo '<td>食譜名稱</td></tr></thead><tbody>';?>
    <?php
    for($i=1;$i<=mysqli_num_rows($data);$i++)
    {
        echo '<tr>';
        while($check = $data->fetch_object())
        {
            echo '<tr><td><a class = "searchResult" href=recipe.php?recipe="'.$check -> 菜名.'">'.$check -> 菜名.'</a></td>';
        }
        echo '</tr>';
    }
    echo '</tbody></table></div></center>';
    ?>

<p style="text-align: center">
    <?php
    for($i=1;$i<=$pages;$i++)
    {
        echo "<a href=SearchType.php?p=$i style=\"border-style:solid;text-decoration: none;color:black\">"."&nbsp;".$i."&nbsp;"."</a>";
        echo "&nbsp;";
    }
    if($pages == 0)
    {
        $pages = 1;
        echo "查無資料";
    }
    ?>
</p>
<p style="text-align: center">第<?php echo $p?>頁/共有<?php echo $pages?>頁</p>
</body>
</html>