$(function () {
  //test_mode();
  init();

  function test_mode() {
    $("#btn1").attr("disabled", "true");
    $("#online_message").removeAttr("hidden");
    $("#test_title").text("(开发中)");
    $("#btn1").attr("class", "btn btn-secondary");
  }

  function init() {
    var now = new Date();
    $("#start_date").val(now.format("yyyy-MM-dd"));
    now.setDate(now.getDate() + Number($("#len_text").val()));
    $("#end_date").text(now.format("yyyy-MM-dd"));
  }

  $("#btn1").click(function () {
    //sendRequest($("#len_text").val(), $("#start_date").val(), $("#out_time").val());

    $.ajax({
      url: './../main.php',
      type: 'post',
      dataType: 'json',
      //data: JSON.stringify({data:{status: "start"}}),
      data: data,
      cache: false,
      success: function (res) {
        $("#res").text(res);
        if (res.resultStat == "success") {

        } else {

        }
      },
      error: function (e) {

      }
    });
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
    'stuStartTime': String($("#out_time").val()),
    'stuReason': String($("input[name='stuReason']").val()),
    'stuWcdz': String($("input[name='stuWcdz']").val()),
    'stuJjlxr': String($("input[name='stuJjlxr']").val()),
    'stuJjlxrLxfs': String($("input[name='stuJjlxrLxfs']").val()),
    'startDate' : String($("#start_date").val()),
    'times' : String($("#len_text").val())
  };
  return data;
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

  if (/(y+)/i.test(fmt)) {
    fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
  }

  for (var k in o) {
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