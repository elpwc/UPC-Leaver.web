require "dbcfg.php";


$q = isset($_GET['q'])? htmlspecialchars($_GET['q']) : '';
if($q) {
        if($q =='RUNOOB') {
                echo '菜鸟教程<br>http://www.runoob.com';
        } else if($q =='GOOGLE') {
                echo 'Google 搜索<br>http://www.google.com';
        } else if($q =='TAOBAO') {
                echo '淘宝<br>http://www.taobao.com';
        }
}

$link = @mysql_connect(HOST,USER,PASS) or die("提示：数据库连接失败！");
mysql_select_db(DBNAME,$link);
mysql_set_charset('utf8',$link);
$sql = 'select * from news order by id asc';
$result = mysql_query($sql,$link);