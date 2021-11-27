$(function () {
  //test_mode();
  init();
  comment_reload(0, 9, 1, -1);

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
    if (String($("input[name='stuXh']").val()) == "") {
      $("#tips-message").text('请先输入学号()');
    } else {
      $("#tips-message").text('开始申请，正在取回结果，请假天数越多等待时间越久（大概一天1秒(?)），请稍等...');
      $("#btn1").attr("disabled", "true");
      var data = getData();

      $.ajax({
        url: './main.php',
        type: 'post',
        //dataType: 'json',
        data: data,
        cache: false,
        success: function (res) {
          $("#tips-message").text('申请完毕，学校接口返回的结果如下:');
          var restext = res.split("|")[1];
          $("#result-message").html(restext);
        },
        error: function (e) {
        }
      });

      $("#btn1").removeAttr("disabled");
    }
  });


  $("#btn2").click(function () {
    var text = String($("input[name='comment-text']").val());
    if (text != "") {
      $("#comment-tips").attr("hidden", "true");

      var data = {
        'comment-name': String($("input[name='comment-name']").val()).replace(/<script/ig, "<scribble").replace(/<\/script>/ig, "</scribble>").replace(/<style/ig, "<steel").replace(/<\/style>/ig, "</steel>"),
        'comment-text': String($("input[name='comment-text']").val()).replace(/<script/ig, "<scribble").replace(/<\/script>/ig, "</scribble>").replace(/<style/ig, "<steel").replace(/<\/style>/ig, "</steel>")
      };

      $.ajax({
        url: './comment.php',
        type: 'post',
        dataType: 'json',
        data: data,
        cache: false,
        success: function (res) {
        },
        error: function (e) {
        }
      });

      $("#comment-tb").val("");
      wait(function () {
        comment_reload(0, 9, 1, -1);
      }, 500);
    } else {
      $("#comment-tips").removeAttr("hidden");
    }
  });

  $("#btn3").click(function () {

  });

  $("#btn4").click(function () {
    var senkou_ = senkou[getRadom(0, senkou.length - 1)];
    $("input[name='stuXy']").val(collages[getRadom(0, collages.length - 1)]);
    $("input[name='stuZy']").val(senkou_[0]);
    $("input[name='stuMz']").val(getMinzu());
    $("input[name='stuBj']").val(senkou_[1] + getGrade(String($("input[name='stuXh']").val())) + "0" + String(getRadom(1, 5)));
    $("input[name='stuLxfs']").val(getphonenum());
    $("input[name='stuJzdh']").val(getphonenum());
    $("input[name='stuJtfs']").val(traffic[getRadom(0, traffic.length - 1)]);
    $("#out_time").val(getouttime());
    $("input[name='stuReason']").val(reason[getRadom(0, reason.length - 1)]);
    $("input[name='stuWcdz']").val(address[getRadom(0, address.length - 1)]);
    $("input[name='stuJjlxr']").val(getName());
    $("input[name='stuJjlxrLxfs']").val(getphonenum());
  });

  $("#btn5").click(function () {
    $("input[name='stuXy']").val('');
    $("input[name='stuZy']").val('');
    $("input[name='stuMz']").val('');
    $("input[name='stuBj']").val('');
    $("input[name='stuLxfs']").val('');
    $("input[name='stuJzdh']").val('');
    $("input[name='stuJtfs']").val('');
    $("#out_time").val('08:00');
    $("input[name='stuReason']").val('');
    $("input[name='stuWcdz']").val('');
    $("input[name='stuJjlxr']").val('');
    $("input[name='stuJjlxrLxfs']").val('');
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

function comment_reload(start, end, current, page_count) {
  $(function () {
    $.ajax({
      type: "POST",
      url: "reloadcomm.php",
      data: { start: String(start), end: String(end) },
    })
      .done(function (data) {
        $('#comment-div').html(data);
        if (Number(page_count) == -1) {//初始化
          $('#page-no1').attr("class", "page-item active");
        } else {
          for (var i = 1; i <= Number(page_count); i++) {
            if (Number(i) == Number(current)) {
              $('#page-no' + String(i)).attr("class", "page-item active");
            } else {
              $('#page-no' + String(i)).attr("class", "page-item");
            }
          }
        }


      });
  });
}


function getphonenum() {
  return "1" + String(getRadom(1000000000, 9999999999));
}

function getouttime() {
  return String(getRadom(7, 22)).padStart(2, "0") + ":" + String(getRadom(0, 59)).padStart(2, "0");
}

function wait(callback, seconds) {
  var timelag = null;
  timelag = window.setTimeout(callback, seconds);
}

function getData() {
  data = {
    'stuXh': String($("input[name='stuXh']").val()).replace(/<script/ig, "<scribble"),
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
    'startDate': String($("#start_date").val()),
    'times': String($("#len_text").val())
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

function getRadom(begin, end) {
  return Math.floor(Math.random() * (end - begin + 1)) + begin;
}

function getGrade(sid) {
  if (sid.length > 5) {
    var head = sid.substr(0, 2);
    if (isIntNum(head)) {
      if (Number(head) >= 14 && Number(head) <= 21) {
        return head;
      }
    }
  }
  return "17";
}

var collages = new Array(
  "地球科学与技术学院",
  "石油工程学院",
  "化学工程学院",
  "机电工程学院",
  "储运与建筑工程学院",
  "材料科学与工程学院",
  "新能源学院",
  "海洋与空间信息学院",
  "控制科学与工程学院",
  "计算机科学与技术学院",
  "经济管理学院",
  "理学院",
  "外国语学院",
  "文法学院",
  "马克思主义学院",
  "体育教学部"
);

var senkou = new Array(
  new Array("勘查技术与工程", "勘察"),
  new Array("石油工程", "石工"),
  new Array("船舶与海洋工程", "海工"),
  new Array("海洋油气工程", "海油"),
  new Array("化学工程与工艺", "化工"),
  new Array("应用化学", "应化"),
  new Array("环境工程", "环境"),
  new Array("能源化学工程", "能源"),
  new Array("机械设计制造及其自动化", "机自"),
  new Array("车辆工程", "车辆"),
  new Array("机械工程", "机工"),
  new Array("智能制造工程", "智能"),
  new Array("安全工程", "安全"),
  new Array("工业设计", "工设"),
  new Array("土木工程", "土木"),
  new Array("油气储运工程", "储运"),
  new Array("建筑环境与能源应用工程", "建环"),
  new Array("建筑学", "建筑"),
  new Array("材料成型及控制工程", "材控"),
  new Array("材料科学与工程", "材料"),
  new Array("材料物理", "财物"),
  new Array("材料化学", "财化"),
  new Array("新能源材料与器件", "新能源"),
  new Array("过程装备与控制工程", "过控"),
  new Array("能源与动力工程", "能动"),
  new Array("电气工程及其自动化", "电气"),
  new Array("环保设备工程", "环设"),
  new Array("测绘工程", "测绘"),
  new Array("地理信息科学", "地信"),
  new Array("电子信息工程", "电信"),
  new Array("通信工程", "通信"),
  new Array("自动化", "自动化"),
  new Array("测控技术与仪器", "测控"),
  new Array("计算机科学与技术", "计科"),
  new Array("软件工程", "软件"),
  new Array("物联网工程", "物联"),
  new Array("智能科学与技术", "智科"),
  new Array("工程管理", "工管"),
  new Array("信息管理与信息系统", "信管"),
  new Array("会计学", "会计"),
  new Array("市场营销", "市场"),
  new Array("经济学", "经济"),
  new Array("财务管理", "财管"),
  new Array("国际经济与贸易", "国贸"),
  new Array("行政管理", "行政"),
  new Array("信息与计算科学", "信息"),
  new Array("数学与应用数学", "数学"),
  new Array("应用物理学", "应物"),
  new Array("光电信息科学与工程", "光电"),
  new Array("化学", "化学"),
  new Array("数据科学与大数据技术", "数科"),
  new Array("英语", "英语"),
  new Array("俄语", "俄语"),
  new Array("法学", "法学"),
  new Array("汉语言文学", "汉语言"),
  new Array("音乐学", "音乐")
);

var reason = new Array(
  "吃饭",
  "约饭",
  "去吃饭",
  "去约饭",
  "有人叫吃饭",
  "有人叫去约饭",
  "吃火锅",
  "和舍友吃火锅",
  "吃烧烤",
  "有人叫吃烤肉",
  "和朋友吃烤肉",
  "饭",
  "恰饭",
  "宿舍恰饭",
  "宿舍聚餐",
  "聚餐",
  "朋友聚餐",
  "朋友约饭",
  "海底捞",
  "吃日料",
  "吃韩料",
  "吃锅边鱼",
  "吃冒菜",
  "吃烤肉",

  "看电影",
  "去电影院",
  "电影院",
  "电影",
  "宿舍看电影",
  "约看电影",
  "看首映",

  "取东西",
  "去快递",
  "送快递",
  "取个东西",

  "买衣服",
  "买裤子",
  "买换季衣服",
  "买鞋",
  "看衣服",

  "接人",
  "送人",

  "参加活动",
  "参加演出",

  "散心",
  "跑步",
  "散步",

  "就是想出去"
);

var traffic = new Array(
  "步行",
  "公交",
  "出租",
  "出租车",
  "公交车",
  "班车",
  "打的",
  "的士",
  "taxi",
  "bus",
  "Bus",
  "走",
  "走路",
  "坐车",
  "车",
  "快车",
  "叫车",
  "网约车",
  "Taxi",
  "走步",
  "徒步"
);

var address = new Array(
  "北门",
  "南门",
  "西北门",
  "西北门外",
  "西北门对面",
  "南门外",
  "海边",
  "黄岛",
  "黄岛区",
  "黄岛区内",
  "区内",
  "学校周边",
  "学校附近",
  "学校旁边",
  "学校周围",
  "学校边",
  "校门外",
  "北门外",
  "吾悦",
  "家佳源",
  "吾悦商城",
  "嘉年华",
  "海边嘉年华",
  "市区",
  "青岛市",
  "麦凯乐",
  "餐馆",
  "饭店",
  "门外"
);

function getMinzu() {
  var xing = new Array(
    new Array("汉族", 0, 90),
    new Array("壮族", 91, 92),
    new Array("回族", 93, 93),
    new Array("满族", 94, 94),
    new Array("苗族", 95, 95),
    new Array("彝族", 96, 96),
    new Array("土家族", 97, 97),
    new Array("蒙古族", 98, 98),
    new Array("侗族", 99, 99),
    new Array("朝鲜族", 100, 100)
  );
  var num = getRadom(0, 100);
  for (var i = 0; i < xing.length; i++) {
    if (num >= xing[i][1] && num <= xing[i][2]) {
      return xing[i][0];
    }
  }
  return "汉族";
}

function getXing() {
  var xing = new Array(
    new Array("王", 0, 7),
    new Array("李", 8, 14),
    new Array("张", 15, 21),
    new Array("刘", 22, 26),
    new Array("陈", 27, 31),
    new Array("杨", 32, 34),
    new Array("黄", 35, 37),
    new Array("吴", 38, 39),
    new Array("赵", 40, 41),
    new Array("吴", 42, 43),
    new Array("周", 44, 45),
    new Array("徐", 46, 47),
    new Array("孙", 48, 49),
    new Array("马", 50, 51),
    new Array("朱", 52, 53),
    new Array("胡", 54, 55),
    new Array("林", 56, 57),
    new Array("郭", 58, 59),
    new Array("何", 60, 61),
    new Array("高", 62, 63),
    new Array("罗", 64, 65),
    new Array("郑", 66, 67),
    new Array("谢", 68, 69),
    new Array("宋", 70, 71),
    new Array("唐", 72, 73),
    new Array("许", 74, 75),
    new Array("邓", 76, 77),
    new Array("冯", 78, 79),
    new Array("韩", 80, 81),
    new Array("曹", 82, 83),
    new Array("曾", 84, 85),
    new Array("彭", 86, 87),
    new Array("萧", 88, 89),
    new Array("蔡", 90, 91),
    new Array("潘", 92, 93),
    new Array("田", 94, 95),
    new Array("董", 96, 97),
    new Array("袁", 98, 99),
    new Array("于", 100, 100)
  );
  var num = getRadom(0, 100);
  for (var i = 0; i < xing.length; i++) {
    if (num >= xing[i][1] && num <= xing[i][2]) {
      return xing[i][0];
    }
  }
  return "无";
}

function getMing() {
  var ming = new Array(
    "明", "国", "华", "建", "文", "平", "志", "伟", "东", "海", "强", "晓", "生", "光", "林", "小", "民", "永", "杰", "军", "波", "成", "荣", "新", "峰", "刚", "家", "龙", "德", "庆", "斌", "辉", "良", "玉", "俊", "立", "浩", "天", "宏", "子", "金", "健", "一", "忠", "洪", "江", "福", "祥", "中", "正", "振", "勇", "耀", "春", "大", "宁", "亮", "宇", "兴", "宝", "少", "剑", "云", "学", "仁", "涛", "瑞", "飞", "鹏", "安", "亚", "泽", "世", "汉", "达", "卫", "利", "胜", "敏", "群", "松", "克", "清", "长", "嘉", "红", "山", "贤", "阳", "乐", "锋", "智", "青", "跃", "元", "南", "武", "广", "思", "雄", "锦", "威", "启", "昌", "铭", "维", "义", "宗", "英", "凯", "鸿", "森", "超", "坚", "旭", "政", "传", "康", "继", "翔", "远", "力", "进", "泉", "茂", "毅", "富", "博", "霖", "顺", "信", "凡", "豪", "树", "和", "恩", "向", "道", "川", "彬", "柏", "磊", "敬", "书", "鸣", "芳", "培", "全", "炳", "基", "冠", "晖", "京", "欣", "廷", "哲", "保", "秋", "君", "劲", "栋", "仲", "权", "奇", "礼", "楠", "炜", "友", "年", "震", "鑫", "雷", "兵", "万", "星", "骏", "伦", "绍", "麟", "雨", "行", "才", "希", "彦", "兆", "贵", "源", "有", "景", "升", "惠", "臣", "慧", "开", "章", "润", "高", "佳", "虎", "根", "诚", "夫", "声", "冬", "奎", "扬", "双", "坤", "镇", "楚", "水", "铁", "喜", "之", "迪", "泰", "方", "同", "滨", "邦", "先", "聪", "朝", "善", "非", "恒", "晋", "汝", "丹", "为", "晨", "乃", "秀", "岩", "辰", "洋", "然", "厚", "灿", "卓", "轩", "帆", "若", "连", "勋", "祖", "锡", "吉", "崇", "钧", "田", "石", "奕", "发", "洲", "彪", "钢", "运", "伯", "满", "庭", "申", "湘", "皓", "承", "梓", "雪", "孟", "其", "潮", "冰", "怀", "鲁", "裕", "翰", "征", "谦", "航", "士", "尧", "标", "洁", "城", "寿", "枫", "革", "纯", "风", "化", "逸", "腾", "岳", "银", "鹤", "琳", "显", "焕", "来", "心", "凤", "睿", "勤", "延", "凌", "昊", "西", "羽", "百", "捷", "定", "琦", "圣", "佩", "麒", "虹", "如", "靖", "日", "咏", "会", "久", "昕", "黎", "桂", "玮", "燕", "可", "越", "彤", "雁", "孝", "宪", "萌", "颖", "艺", "夏", "桐", "月", "瑜", "沛", "杨", "钰", "兰", "怡", "灵", "淇", "美", "琪", "亦", "晶", "舒", "菁", "真", "涵", "爽", "雅", "爱", "依", "静", "棋", "宜", "男", "蔚", "芝", "菲", "露", "娜", "珊", "雯", "淑", "曼", "萍", "珠", "诗", "璇", "琴", "素", "梅", "玲", "蕾", "艳", "紫", "珍", "丽", "仪", "梦", "倩", "伊", "茜", "妍", "碧", "芬", "儿", "岚", "婷", "菊", "妮", "媛", "莲", "娟", "刚", "勇", "毅", "俊", "峰", "强", "军", "平", "保", "东", "文", "辉", "力", "明", "永", "健", "世", "广", "志", "义", "兴", "良", "海", "山", "仁", "波", "宁", "贵", "福", "生", "龙", "元", "全", "国", "胜", "学", "祥", "才", "发", "武", "新", "利", "清", "飞", "彬", "富", "顺", "信", "子", "杰", "涛", "昌", "成", "康", "星", "光", "天", "达", "安", "岩", "中", "茂", "进", "有", "坚", "和", "彪", "博", "诚", "先", "敬", "震", "振", "壮", "会", "思", "群", "豪", "心", "邦", "承", "乐", "绍", "功", "松", "善", "厚", "庆", "磊", "民", "友", "裕", "河", "哲", "江", "超", "浩", "亮", "政", "谦", "亨", "奇", "固", "之", "轮", "翰", "朗", "伯", "宏", "言", "若", "鸣", "朋", "斌", "梁", "栋", "维", "启", "克", "伦", "翔", "旭", "鹏", "泽", "晨", "辰", "士", "以", "建", "家", "致", "树", "炎", "德", "行", "时", "泰", "盛", "雄", "琛", "钧"
  );
  var len = 1;
  var ran = getRadom(0, 100);
  if (ran > 35 && ran <= 99) {
    len += 1;
  } else if (ran > 99) {
    len += 2;
  }
  var res = "";
  for (var i = 0; i < len; i++) {
    res += ming[getRadom(0, ming.length - 1)];
  }
  return res;
}

function getName() {
  return getXing() + getMing();
}
