<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <title>⊌PC Leaver - 批量出校请假服务</title>
  <link rel="stylesheet" href="./lib/main.css" />
  <!--link rel="stylesheet" href="./lib/bootstrap.min.css" /-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <!--script src="./lib/jquery-3.3.1.min.js"></script-->
  <script src="https://cdn.staticfile.org/jquery/3.3.1/jquery.min.js"></script>
  <script src="./lib/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</head>

<body>
  <div id="body_div" class="container-fluid">
    <div class="head_div">
      <h1><span id="logo">&nbsp;⊌</span><span id="downp">P</span>C Leaver - 批量出校请假服务&nbsp;<span id="test_title"></span>
      </h1><br>
      <p>
        <?php
          require "dbcfg.php";
          $link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die();
          mysqli_set_charset($link, 'utf8');
          
          $sql = "SELECT COUNT(DISTINCT(stu_id)) FROM record;";
          $result = mysqli_query($link, $sql);
          if ($result->num_rows > 0) {
              // 输出数据
              while ($row = $result->fetch_assoc()) {
                echo "已有".$row["COUNT(DISTINCT(stu_id))"]."人使用了此工具";
              }
          }
          
        ?>
      </p>
    </div>
    <div id="form_div" class="card">

      <!--<p class="red">*请确保已连接校园网</p>-->
      <br>
      <input type="text" class="form-control" placeholder="学号(乱输也会显示成功是学校接口的问题，和工具本身没关系()只要输对了还是可以请假()" name="stuXh"><br>
      <input type="text" class="form-control" placeholder="姓名(输入什么都能通过，但必须有(会在公众号的通知里反映出来)" name="stuXm"><br>
      <!--
      <input type="text" class="form-control" placeholder="学院" name="stuXy"><br>
      <input type="text" class="form-control" placeholder="专业" name="stuZy"><br>
      <input type="text" class="form-control" placeholder="民族" name="stuMz"><br>
      <input type="text" class="form-control" placeholder="班级" name="stuBj"><br>
      <p class="red">*以上信息请按照<a
          href="https://app.upc.edu.cn/uc/api/oauth/index?redirect=http://stu.gac.upc.edu.cn:8089/xswc&appid=200200819124942787&state=2">平安石大请假页面</a>内的信息如实填写
      </p><br>
      <br>
      联系方式<input type="text" class="form-control" name="stuLxfs" value="1145141919" /><br>
      家长电话<input type="text" class="form-control" name="stuJzdh" value="1145141919" /><br>
      交通方式<input type="text" class="form-control" name="stuJtfs" value="步行" /><br>
      外出事由<input type="text" class="form-control" name="stuReason" value="吃饭" /><br>
      外出地址<input type="text" class="form-control" name="stuWcdz" value="黄岛区内" /><br>
      外出紧急联系人<input type="text" class="form-control" name="stuJjlxr" value="舍友" /><br>
      紧急联系人方式<input type="text" class="form-control" name="stuJjlxrLxfs" value="1145141919" /><br>
      *以上信息可以随意填写
-->
      <big>请假天数(1-100)</big><input type="number" class="form-control" id="len_text" value="60" /><br>
      请假开始日期<input id="start_date" type="date" class="form-control" value="2020-10-10" /><br>
      请假结束日期<br><span id="end_date">2020-10-10</span><br>
      <!--每日外出时间(随意设定)<input id="out_time" class="form-control" type="time" value="08:00" /><br>-->
      <button id="btn1" class="btn btn-primary">一键请假</button>
      <p class="red" id="online_message" hidden>将于5月上旬上线(大概)</p>
      <span id="tips-message"></span>
      <div id="result-message"></div>
      <br>
      *所有信息仅用于与校方接口验证，不会在服务器存储。<br>
      *成功之后请假批准会在每天凌晨2点多在平安石大内推送。<br>
    </div>
    <br><br>

    <div class="card">
    <big>匿名留言板()</big>
      <input type="text" class="form-control" placeholder="名字(可留空)" name="comment-name" value="" /><br>
      <input type="text" class="form-control" placeholder="留言" name="comment-text" id="comment-tb" value="" /><br>
      <p hidden id="comment-tips" class="red">写上留言才能发送嗷</p><br>
      <button id="btn2" class="btn btn-primary">发送</button>
      <div id="comment-div">
        
      </div>

    </div>
  </div>

</body>

</html>