<?php
require "dbcfg.php";
$link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("提示：数据库连接失败！");
mysqli_set_charset($link, 'utf8');
$sql = "SELECT * FROM messages ORDER BY id DESC;";

$result = mysqli_query($link, $sql);
$res = '';

$start = (int)$_POST['start'];
$end = (int)$_POST['end'];

if ($result->num_rows > 0) {
    $i = 0;
    while ($row = $result->fetch_assoc()) {
        if ($i>=$start && $i<=$end) {
            $name_text = 'class="my-conment-name">'.$row["name"];
            if ($row["name"] == '') {
                $name_text = 'class="my-conment-nameless">~无名氏~';
            }
            $res.= '<div class="card"><p><span>#'.$row["id"]." ".$row["time"].'</span>&nbsp;&nbsp;<span '.$name_text.'</span></p><p>'.$row["text"].'</p></div>';
        } elseif ($i>$end) {
            break;
        }
        $i++;
    }
}
echo $res;
