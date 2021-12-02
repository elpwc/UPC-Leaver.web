<?php
require "dbcfg.php";

//ob_end_clean();//清空（擦除）缓冲区并关闭输出缓冲
//ob_implicit_flush(true);

/*
meta data:
data: {
  "app_id":"458","node_id":"","form_data":{"1259":{"User_4":"韦润乾","User_6":"地球科学与技术学院","User_8":"1901040412","User_10":"勘查技术与工程(测井)","User_14":"17865329621","User_55":"壮族","User_60":"勘查(测井)1904","Input_16":"打车","Input_18":"17776231863","Input_22":"购买生活用品","Input_26":"吾悅","Input_28":"李田所","Input_30":"11451419198","Calendar_20":"2021-11-28T16:00:00.000Z","Checkbox_34":[{"value":"1","name":"本人严格按照请假外出要求做好疫情防控工作，一卡通/身份证确保本人使用，所到地点、交通方式、返校时间等均与请假所填写信息一致，在外出期间随时与辅导员保持联系，注重人身安全、财产安全，若发生事故，责任自负。"}]}},"userview":1}
agent_uid: 
starter_depart_id: 61408
test_uid: 0
*/
/*
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
*/
//2021-11-28T16:00:00.000Z
function getDataByTimeDate($date)
{
  return array(
    'data' => urlencode('{"app_id":"458","node_id":"","form_data":{"1259":{"User_4":"' .
      $_POST['stuXm'] .
      '","User_6":"' .
      $_POST['stuXy'] .
      '","User_8":"' .
      $_POST['stuXh'] .
      '","User_10":"' .
      $_POST['stuZy'] .
      '","User_14":"' .
      $_POST['stuLxfs'] .
      '","User_55":"' .
      $_POST['stuMz'] .
      '","User_60":"' .
      $_POST['stuBj'] .
      '","Input_16":"' .
      $_POST['stuJtfs'] .
      '","Input_18":"' .
      $_POST['stuJzdh'] .
      '","Input_22":"' .
      $_POST['stuReason'] .
      '","Input_26":"' .
      $_POST['stuWcdz'] .
      '","Input_28":"' .
      $_POST['stuJjlxr'] .
      '","Input_30":"' .
      $_POST['stuJjlxrLxfs'] .
      '","Calendar_20":"' .
      $date .
      '","Checkbox_34":[{"value":"1","name":"本人严格按照请假外出要求做好疫情防控工作，一卡通/身份证确保本人使用，所到地点、交通方式、返校时间等均与请假所填写信息一致，在外出期间随时与辅导员保持联系，注重人身安全、财产安全，若发生事故，责任自负。"}]}},"userview":1}'),
    'agent_uid' => '',
    'starter_depart_id' => '61408',
    'test_uid' => '0'
  );
}



$link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die();
//mysqli_select_db($link, DBNAME);
mysqli_set_charset($link, 'utf8');

$sql = "INSERT INTO record (stu_id) VALUES ('" . $_POST['stuXh'] . "');";
$result = mysqli_query($link, $sql);

$date = date_create();
$startdate = $_POST['startDate'];
$times = $_POST['times'];
//$startdate = "2021-05-09";
//$times = "3";
$date = date_timestamp_set($date, strtotime($startdate));
//$res = array();
$restext = '|';
$i = 0;
while ($i < (int)$times) {
  //2021-11-28T16:00:00.000Z
  $timedate = date_format($date, "Y-m-d") . 'T16:00:00.000Z';
  //$data['stuStartTime'] = date_format($date, "Y-m-d ") . $_POST['stuStartTime'] . ':00';
  //$res = json_decode(send_post("http://stu.gac.upc.edu.cn:8089/stuqj/addQjMess", $data));
  $res = curlPost_new("https://service.upc.edu.cn/site/apps/launch", getDataByTimeDate($timedate));
  //sleep(70);
  echo getDataByTimeDate($timedate)['data'];
  echo $timedate;
  echo 'res|';
  echo $res;
  echo  '|end.';

  /*
  $msg = isset($res->mess) ? $res->mess : '<span class="red">未知错误，可能学校没有开启接口。</span>';
  if ($msg == "无学号姓名信息") {
    $msg = "<span class='red'>无学号姓名信息</span>";
  }
  if ($msg == "成功") {
    $msg = "<span class='green'>成功</span>";
  }
  $restext .= '<p>' . date_format($date, "Y-m-d：") . $msg . '</p>';
  */
  /*
  if($res['resultStat']=='success'){
    echo date_format($date,"Y-m-d：").$res['mess'];
  }else{9
    echo date_format($date,"Y-m-d：").$res['mess'];
  }*/
  //日期加1天
  date_add($date, date_interval_create_from_date_string("1 day"));

  $i++;
}
echo $restext;
//for ($i = 0; $i < (int)$times; $i++) {}


function send_post($url, $post_data)
{
  $postdata = http_build_query($post_data);
  $options = array(
    'http' => array(
      'method' => 'POST',
      //'header' => "User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0) Gecko/20100101 Firefox/86.0/r/nAccept:*/*/r/nAccept-Language:zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2/r/nContent-Type:application/x-www-form-urlencoded;charset=UTF-8/r/nX-Requested-With:XMLHttpRequest/r/nOrigin:http://stu.gac.upc.edu.cn:8089/r/nConnection:keep-alive/r/nReferer:http://stu.gac.upc.edu.cn:8089/xswc&appid=200200819124942787&state=2",
      'header' =>
      "Accept:application/json, text/plain, */*/r/n" .
        "Accept-Encoding: gzip, deflate, br/r/n" .
        "Accept-Language:zh-CN,zh;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6/r/n" .
        "Connection: keep-alive/r/n" .
        "Content-Length: 1955/r/n" .
        //"Content-Type: application/x-www-form-urlencoded/r/n" .
        "Cookie: vjuid=168336; vjvd=cf1a1051c2723709009386cecdefa1a7; vt=153712641/r/n" .
        "Host: service.upc.edu.cn/r/n" .
        "Origin: https://service.upc.edu.cn/r/n" .
        "Referer: https://service.upc.edu.cn/v2/matter/start?id=458/r/n" .
        "sec-ch-ua: \" Not A;Brand\";v=\"99\", \"Chromium\";v=\"96\", \"Microsoft Edge\";v=\"96\"/r/n" .
        "sec-ch-ua-mobile: ?0/r/n" .
        "sec-ch-ua-platform: \"Windows\"/r/n" .
        "Sec-Fetch-Dest: empty/r/n" .
        "Sec-Fetch-Mode: cors/r/n" .
        "Sec-Fetch-Site: same-origin/r/n" .
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36 Edg/96.0.1054.29/r/n" .
        "X-Requested-With:XMLHttpRequest/r/n",
      'content' => $postdata,
      'timeout' => 15 * 60 // 超时时间（单位:s）
    )
  );
  $context = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
  return $result;
}

//post
function curlPost($url, $post_data = array())
{

  $header  = array(
    "Accept" => "application/json, text/plain, */*",
    "Accept-Encoding" => " gzip, deflate, br",
    "Accept-Language" => "zh-CN,zh;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6",
    "Connection" => " keep-alive",
    "Content-Length" => " 1955",
    "Content-Type" => " application/x-www-form-urlencoded",
    "Cookie" => " vjuid=168336; vjvd=cf1a1051c2723709009386cecdefa1a7; vt=153712641",
    "Host" => " service.upc.edu.cn",
    "Origin" => " https://service.upc.edu.cn",
    "Referer" => " https://service.upc.edu.cn/v2/matter/start?id=458",
    "sec-ch-ua" => " \" Not A;Brand\";v=\"99\", \"Chromium\";v=\"96\", \"Microsoft Edge\";v=\"96\"",
    "sec-ch-ua-mobile" => " ?0",
    "sec-ch-ua-platform" => " \"Windows\"",
    "Sec-Fetch-Dest" => " empty",
    "Sec-Fetch-Mode" => " cors",
    "Sec-Fetch-Site" => " same-origin",
    "User-Agent" => " Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36 Edg/96.0.1054.29",
    "X-Requested-With" => "XMLHttpRequest",
  );

  if (is_array($post_data)) {
    $post_data = http_build_query($post_data, '', '&');
  }
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  $output = curl_exec($ch);
  curl_close($ch);
  return $output;
}

function curlPost_new($url, $post_data)
{

  $header  = array(
    "Accept" => "application/json, text/plain, */*",
    "Accept-Encoding" => " gzip, deflate, br",
    "Accept-Language" => "zh-CN,zh;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6",
    "Connection" => " keep-alive",
    "Content-Length" => " 1955",
    "Content-Type" => " application/x-www-form-urlencoded",
    "Cookie" => " vjuid=168336; vjvd=cf1a1051c2723709009386cecdefa1a7; vt=153712641",
    "Host" => " service.upc.edu.cn",
    "Origin" => " https://service.upc.edu.cn",
    "Referer" => " https://service.upc.edu.cn/v2/matter/start?id=458",
    "sec-ch-ua" => " \" Not A;Brand\";v=\"99\", \"Chromium\";v=\"96\", \"Microsoft Edge\";v=\"96\"",
    "sec-ch-ua-mobile" => " ?0",
    "sec-ch-ua-platform" => " \"Windows\"",
    "Sec-Fetch-Dest" => " empty",
    "Sec-Fetch-Mode" => " cors",
    "Sec-Fetch-Site" => " same-origin",
    "User-Agent" => " Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36 Edg/96.0.1054.29",
    "X-Requested-With" => "XMLHttpRequest",
  );

  return curl_request($url, $post_data, $header, 'https://service.upc.edu.cn/v2/matter/start?id=458')['data'];
}


/**
 * CURL请求函数:支持POST及基本header头信息定义

 * @param [api_url:目标url | post_data:post参数 | header:头信息数组 | referer_url:来源url]
 * @return [code:状态码(200执行成功、400执行异常) | data:数据]
 */
function curl_request($api_url, $post_data = [], $header = [], $referer_url = '')
{
  $ch = curl_init(); //初始化CURL句柄
  curl_setopt($ch, CURLOPT_URL, $api_url);

  /**配置返回信息**/
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //获取的信息以文件流的形式返回，不直接输出
  curl_setopt($ch, CURLOPT_HEADER, 0); //不返回header部分

  /**配置超时**/
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); //连接前等待时间,0不等待
  curl_setopt($ch, CURLOPT_TIMEOUT, 5); //连接后等待时间,0不等待。如下载mp3

  /**配置页面重定向**/
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); //跟踪爬取重定向页面
  curl_setopt($ch, CURLOPT_MAXREDIRS, 10); //指定最多的HTTP重定向的数量
  curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // 自动设置Referer

  /**配置Header、请求头、协议信息**/
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  curl_setopt($ch, CURLOPT_ENCODING, ""); //Accept-Encoding编码，支持"identity"/"deflate"/"gzip",空支持所有编码
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36 Edg/96.0.1054.29"); //模拟浏览器头信息
  $referer_url && curl_setopt($ch, CURLOPT_REFERER, $referer_url); //伪造来源地址
  //curl_setopt( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );    //设置curl使用的HTTP协议

  /**配置POST请求**/
  if ($post_data && is_array($post_data)) {
    curl_setopt($ch, CURLOPT_POST, 1); //支持post提交数据
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data)); //
  }

  /**禁止证书验证防止curl输出空白**/
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //禁止 cURL 验证对等证书
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //是否检测服务器的域名与证书上的是否一致

  $code = 200; //执行成功
  $data = curl_exec($ch);
  //捕抓异常
  if (curl_errno($ch)) {
    $code = 400; //执行异常
    $data = curl_error($ch);
  }
  curl_close($ch);

  return ['code' => $code, 'data' => $data];
}
