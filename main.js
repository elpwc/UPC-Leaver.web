$(function () {
  //test_mode();
  init();

  function test_mode() {
    $("#btn1").attr("disabled", "true");
    $("#online_message").removeAttr("hidden");
    $("#test_title").text("(即将上线)");
  }

  function init() {
    var now = new Date();
    $("#start_date").val(now.format("yyyy-MM-dd"));
    now.setDate(now.getDate() + Number($("#len_text").val()));
    $("#end_date").text(now.format("yyyy-MM-dd"));
  }

  $("#btn1").click(function () {
    alert(1);
    sendRequest($("#len_text").val(), $("#start_date").val(), $("#out_time").val());
  });

  $("#len_text").bind("input propertychange", function () {
    if (isIntNum($("#len_text").val())) {
      if (Number($("#len_text").val()) > 100) {
        $("#len_text").val(100);
      } else if (Number($("#len_text").val()) < 1) {
        $("#len_text").val(1);
      } else { }
      var now = new Date();
      now.setDate(now.getDate() + Number($("#len_text").val()) - 1);
      $("#end_date").text(now.format("yyyy-MM-dd"));
    } else {
      $("#len_text").val(1);
    }
  });


});

function getHeaders() {
  headers = {
    //'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0) Gecko/20100101 Firefox/86.0',
    'Accept': '*/*',
    'Accept-Language': 'zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
    'X-Requested-With': 'XMLHttpRequest'
    //'Origin': 'http://stu.gac.upc.edu.cn:8089'
    //'Connection': 'keep-alive',
    //'Referer': 'http://stu.gac.upc.edu.cn:8089/xswc&appid=200200819124942787&state=2',
  };
  return headers;
}

function getData() {
  data = {
    'stuXh': String($("input[name='stuXh']").val()),
    'stuXm': String($("input[name='stuXm']").val()),
    'stuXy': String($("input[name='stuXy']").val()),
    'stuZy': String($("input[name='stuZy']").val()),
    'stuMz': String($("input[name='stuMz']").val()),
    'stuBj': String($("input[name='stuBj']").val()),
    'stuLxfs': String($("input[name='stuLxfs']").val()),
    'stuJzdh': String($("input[name='stuJzdh']").val()),
    'stuJtfs': String($("input[name='stuJtfs']").val()),
    'stuStartTime': '',
    'stuReason': String($("input[name='stuReason']").val()),
    'stuWcdz': String($("input[name='stuWcdz']").val()),
    'stuJjlxr': String($("input[name='stuJjlxr']").val()),
    'stuJjlxrLxfs': String($("input[name='stuJjlxrLxfs']").val())
  };
  return data;
}

function sendRequestOnce(header, data, date, time) {
  data.stuStartTime = date.format("yyyy-mm-dd ") + time +":00";
  $.ajax({
    url: 'http://stu.gac.upc.edu.cn:8089/stuqj/addQjMess',
    type: 'post',
    dataType: 'json',
    //data: JSON.stringify({data:{status: "start"}}),
    data: data,
    cache: false,
    headers: header,
    success: function (res) {
      $("#res").text(res);
      if(res.resultStat == "success"){

      }else{

      }
    },
    error: function (e) {

    }
  });
}

function sendRequest(times, startTime_, time) {
  headers = getHeaders();
  data = getData();
  var startTime = new Date(startTime_);
  var t_time = new Date(
    startTime.getFullYear(),
    startTime.getMonth(),
    startTime.getDate()
  );
  for (i = 0; i < times; i++) {
    t_time.setDate(startTime.getDate() + i);
    sendRequestOnce(headers, data, t_time, time);
  }
}


Date.prototype.format = function (fmt) {
  var o = {
    "M+": this.getMonth() + 1,                   //月份
    "d+": this.getDate(),                        //日
    "h+": this.getHours(),                       //小时
    "m+": this.getMinutes(),                     //分
    "s+": this.getSeconds(),                     //秒
    "q+": Math.floor((this.getMonth() + 3) / 3), //季度
    "S": this.getMilliseconds()                  //毫秒
  };

  //  获取年份 
  // ①
  if (/(y+)/i.test(fmt)) {
    fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
  }

  for (var k in o) {
    // ②
    if (new RegExp("(" + k + ")", "i").test(fmt)) {
      fmt = fmt.replace(
        RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    }
  }
  return fmt;
}

function isIntNum(val) {
  var regPos = /^[1-9]\d*$/; // 正整数 
  if (regPos.test(val)) {
    return true;
  }
  return false;
}