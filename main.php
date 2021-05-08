require "dbcfg.php";


$q = $_POST['q']);
if($q) {
        
}

$link = @mysql_connect(HOST,USER,PASS) or die("提示：数据库连接失败！");
mysql_select_db(DBNAME,$link);
mysql_set_charset('utf8',$link);
$sql = 'select * from news order by id asc';
$result = mysql_query($sql,$link);