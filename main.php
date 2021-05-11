<?php
require "dbcfg.php";
$data = array(
  'stuXh' => $_POST['stuXh'],  # 学号
  'stuXm' => $_POST['stuXm'],  # 姓名
  'stuXy' => $_POST['stuXy'],  # 学院
  'stuZy' => $_POST['stuZy'],  # 专业
  'stuMz' => $_POST['stuMz'],  # 民族
  'stuBj' => $_POST['stuBj'],  # 班级
  'stuLxfs' => $_POST['stuLxfs'],  # 联系方式
  'stuJzdh' => $_POST['stuJzdh'],  # 家长电话
  'stuJtfs' => $_POST['stuJtfs'],  # 交通方式
  'stuStartTime' => '',  # 外出时间，可以自动生成，留空即可
  'stuReason' => $_POST['stuReason'],  # 外出事由
  'stuWcdz' => $_POST['stuWcdz'],  # 外出地址（仅限青岛市）
  'stuJjlxr' => $_POST['stuJjlxr'],  # 外出紧急联系人
  'stuJjlxrLxfs' => $_POST['stuJjlxrLxfs']  # 紧急联系人联系方式
);

$link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die();
//mysqli_select_db($link, DBNAME);
mysqli_set_charset($link, 'utf8');

$sql = "INSERT INTO record (stu_id) VALUES ('".$_POST['stuXh']."');";
$result = mysqli_query($link, $sql);

$date=date_create();
$startdate = $_POST['startDate'];
$times = $_POST['times'];
//$startdate = "2021-05-09";
//$times = "3";
date_timestamp_set($date, strtotime($startdate));
//$res = array();
$restext = '|';
for ($i = 0; $i < (int)$times; $i++) {
    $data['stuStartTime'] = date_format($date, "Y-m-d ").$_POST['out_time'].':00';
    $res = json_decode(send_post('http://stu.gac.upc.edu.cn:8089/stuqj/addQjMess', $data));
    $msg = isset($res->mess) ?$res->mess: '未知错误，可能学校没有开启接口。';
    $restext.='<p>'.date_format($date, "Y-m-d：").$msg.'</p>';
    /*
    if($res['resultStat']=='success'){
      echo date_format($date,"Y-m-d：").$res['mess'];
    }else{9
      echo date_format($date,"Y-m-d：").$res['mess'];
    }*/
    date_add($date, date_interval_create_from_date_string("1 day"));
}
echo $restext;

function send_post($url, $post_data)
{
    $postdata = http_build_query($post_data);
    $options = array(
        'http' => array(
            'method' => 'POST',
            //'header' => "User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0) Gecko/20100101 Firefox/86.0/r/nAccept:*/*/r/nAccept-Language:zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2/r/nContent-Type:application/x-www-form-urlencoded;charset=UTF-8/r/nX-Requested-With:XMLHttpRequest/r/nOrigin:http://stu.gac.upc.edu.cn:8089/r/nConnection:keep-alive/r/nReferer:http://stu.gac.upc.edu.cn:8089/xswc&appid=200200819124942787&state=2",
            'header' => "User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0) Gecko/20100101 Firefox/86.0/r/nAccept:*/*/r/nAccept-Language:zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2/r/nX-Requested-With:XMLHttpRequest/r/nOrigin:http://stu.gac.upc.edu.cn:8089/r/nConnection:keep-alive/r/nReferer:http://stu.gac.upc.edu.cn:8089/xswc&appid=200200819124942787&state=2",
            'content' => $postdata,
            'timeout' => 15 * 60 // 超时时间（单位:s）
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}
