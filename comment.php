<?php
require "dbcfg.php";

$comment_name = $_POST['comment-name'];
$comment_text = $_POST['comment-text'];

$link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die("提示：数据库连接失败！");
//mysqli_select_db($link, DBNAME);
mysqli_set_charset($link,'utf8');

$sql = "INSERT INTO messages (name, text) VALUES ('".$comment_name."','".$comment_text."');";

$result = mysqli_query($link, $sql);
