<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <title>⊌PC Leaver - 批量申请出校服务</title>
  <link rel="stylesheet" href="./lib/main.css" />
  <link rel="icon" href="./src/favicon.ico" sizes="32x32" />
  <!--link rel="stylesheet" href="./lib/bootstrap.min.css" /-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
    integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <!--script src="./lib/jquery-3.3.1.min.js"></script-->
  <script src="https://cdn.staticfile.org/jquery/3.3.1/jquery.min.js"></script>
  <script src="./lib/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
    integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF"
    crossorigin="anonymous"></script>
</head>

<body>
  <div id="body_div" class="container-fluid">
    <div class="head_div">
      <h1><span id="logo">&nbsp;⊌</span><span id="downp">P</span>C Leaver - 批量申请出校服务&nbsp;<span id="test_title"></span>
      </h1><br>
      <p>
        <?php
          require "dbcfg.php";
          $link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die();
          mysqli_set_charset($link, 'utf8');
          
          $sql = "SELECT COUNT(DISTINCT(stu_id)) FROM record;";
          $result = mysqli_query($link, $sql);
          if ($result->num_rows > 0) {
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
      <input type="text" class="form-control" placeholder="学号(乱输也会显示成功是学校接口的问题，和工具本身没关系()只要输对了还是可以请假()"
        name="stuXh"><br>
      <input type="text" class="form-control" placeholder="姓名(不管输入得对不对都能通过，但必须有(输入的内容会在公众号的通知里反映出来)" name="stuXm"><br>
      <!--

      *以上信息可以随意填写
      -->
      <big>请假天数(1-100)</big><input type="number" class="form-control" id="len_text" value="60" /><br>
      请假开始日期<input id="start_date" type="date" class="form-control" value="2020-10-10" /><br>
      请假结束日期<br><span id="end_date">2020-10-10</span><br>

      <button id="btn3" class="btn btn-secondary" data-toggle="collapse" data-target="#collapse-div"
        open="0">点此填写详细信息(防止暴露)</button>
      <div class="card">
        <div id="collapse-div" class="collapse">
          <p class="red">这里的信息不填入也可以申请成功，如果实在想填又懒得手动填可以按一下下面的随机填入。<br>
            （民族和紧急联系人姓名是按照人数占比随机生成的。其余的都是在均匀分布中随机选择）<br>
            （建议点一下随机填入再自己改内容）</p>
          <button id="btn4" class="btn btn-dark">随机填入</button>&nbsp;<button id="btn5"
            class="btn btn-danger">全部清空</button>
          <input type="text" class="form-control" placeholder="学院" name="stuXy">
          <input type="text" class="form-control" placeholder="专业" name="stuZy">
          <input type="text" class="form-control" placeholder="民族" name="stuMz">
          <input type="text" class="form-control" placeholder="班级" name="stuBj">
          <!--p class="red">*以上信息请按照<a
              href="https://app.upc.edu.cn/uc/api/oauth/index?redirect=http://stu.gac.upc.edu.cn:8089/xswc&appid=200200819124942787&state=2">平安石大请假页面</a>内的信息如实填写
          </p><br-->
          <input type="text" class="form-control" placeholder="联系方式" name="stuLxfs" value="" />
          <input type="text" class="form-control" placeholder="家长电话" name="stuJzdh" value="" />
          <input type="text" class="form-control" placeholder="交通方式" name="stuJtfs" value="" />
          <input type="text" class="form-control" placeholder="外出事由" name="stuReason" value="" />
          <input type="text" class="form-control" placeholder="外出地址" name="stuWcdz" value="" />
          <input type="text" class="form-control" placeholder="外出紧急联系人" name="stuJjlxr" value="" />
          <input type="text" class="form-control" placeholder="紧急联系人方式" name="stuJjlxrLxfs" value="" />
          每日外出时间(随意设定即可)<input id="out_time" class="form-control" type="time" value="08:00" />
        </div>
      </div>
      <br>
      <div style="background: url('src/bgi.jpg');height: 250px;width: 960px;">
        <button id="btn1" class="btn btn-primary">一键申请外出！！！</button>
        <p class="red" id="online_message" hidden>将于5月上旬上线(大概)</p>
        <span id="tips-message"></span>
        <div id="result-message"></div>
        <br>
        *信息仅用于与校方接口验证，不会在服务器存储。<br>
        *成功之后请假批准会在每天凌晨2点多在平安石大内推送。<br>
        *由于校园网凌晨不对外开放，每日0点左右-8点左右不能使用。<br>
        <span class="red">*校方接口似乎不接受留培学号的申请，就算显示成功了还是出不去(推测)。</span><br>
        <span class="red">*有无留培同学申请完去校门刷卡测试一下，结果发在下面留言板我参考一下谢谢了()。</span><br>
      </div>
    </div>
    <br><br>

    <div class="card">
      <big style="text-align: center;">༺༺匿名留言板༻༻</big><span id="littlescript" style="text-align: center;">(支持除script, style外的html标签(小声))</span>
      <input type="text" class="form-control" placeholder="名字 (可留空)" name="comment-name" value="" /><br>
      <input type="text" class="form-control" placeholder="留言 (出现bug的话，也请写在这里orz)" name="comment-text" id="comment-tb"
        value="" /><br>
      <p hidden id="comment-tips" class="red">写上留言才能发送嗷</p>
      <button id="btn2" class="btn btn-primary">发送留言</button>
      <div id="comment-div">

      </div>
      <div style="text-align: center;">

        <ul class="pagination">
          <?php
                  $link = @mysqli_connect(HOST, USER, PASS, DBNAME) or die();
                  mysqli_set_charset($link, 'utf8');
                  
                  $sql = "SELECT COUNT(id) FROM messages;";
                  $result = mysqli_query($link, $sql);
                  $count = 0;
                  $each_page = 10;

                  if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                          $count = (int)$row["COUNT(id)"];
                      }
                  }
                  $page_num = ceil((double)$count / (double)$each_page);
                  for ($i = 1; $i<=$page_num; $i++) {
                      if ($i == 1) {
                          echo('<li class="page-item"><a class="page-link" href="javascript:comment_reload('.(string)($each_page*($i-1)).','.(string)($each_page*$i-1).','.(string)$i.','.(string)$page_num.');">第一页</a></li>');
                      }
                      echo('<li class="page-item" id="page-no'.(string)$i.'"><a class="page-link" href="javascript:comment_reload('.(string)($each_page*($i-1)).','.(string)($each_page*$i-1).','.(string)$i.','.(string)$page_num.');">'.(string)$i.'</a></li>');
                      if ($i == $page_num) {
                          echo('<li class="page-item"><a class="page-link" href="javascript:comment_reload('.(string)($each_page*($i-1)).','.(string)($each_page*$i-1).','.(string)$i.','.(string)$page_num.');">最后一页</a></li>');
                      }
                  }
        ?>

        </ul>
      </div>

    </div>
    <br><br>
    <div id="bottom-div">
      <button type="button" class="btn btn-link"><a href="https://github.com/elpwc/UPC-Leaver.web">Github</a></button>
      <p style="color: darkgrey; font-size: 10px;">2021 @elpwc All rights reserved.</p>
    </div>
  </div>

</body>

</html>