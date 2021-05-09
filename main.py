#!python
#coding:utf-8
import requests
import json
import time
import datetime
import cgi

form = cgi.FieldStorage()
days = int(form['times'].value)

# 这玩意获取学生基本信息的网址实际上是 https://app.upc.edu.cn/uc/api/oauth/index?redirect=http://stu.gac.upc.edu.cn:8089/xswc&appid=200200819124942787&state=2
# 剩下的前端根本不验证你的 Cookies
headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0) Gecko/20100101 Firefox/86.0',
    'Accept': '*/*',
    'Accept-Language': 'zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
    'X-Requested-With': 'XMLHttpRequest',
    'Origin': 'http://stu.gac.upc.edu.cn:8089',
    'Connection': 'keep-alive',
    'Referer': 'http://stu.gac.upc.edu.cn:8089/xswc&appid=200200819124942787&state=2',
}


# 在填写之前，请先照着 https://app.upc.edu.cn/uc/api/oauth/index?redirect=http://stu.gac.upc.edu.cn:8089/xswc&appid=200200819124942787&state=2 的提示信息和源代码中的注释，完成下面的配置信息
data = {
    'stuXh': form['stuXh'].value,  # 学号
    'stuXm': form['stuXm'].value,  # 姓名
    'stuXy': form['stuXy'].value,  # 学院
    'stuZy': form['stuZy'].value,  # 专业
    'stuMz': form['stuMz'].value,  # 民族
    'stuBj': form['stuBj'].value,  # 班级
    'stuLxfs': form['stuLxfs'].value,  # 联系方式
    'stuJzdh': form['stuJzdh'].value,  # 家长电话
    'stuJtfs': form['stuJtfs'].value,  # 交通方式
    'stuStartTime': form['stuStartTime'].value,  # 外出时间，可以自动生成，留空即可
    'stuReason': form['stuReason'].value,  # 外出事由
    'stuWcdz': form['stuWcdz'].value,  # 外出地址（仅限青岛市）
    'stuJjlxr': form['stuJjlxr'].value,  # 外出紧急联系人
    'stuJjlxrLxfs': form['stuJjlxrLxfs'].value  # 紧急联系人联系方式
    # 至于这个“本人承诺”，纯粹只是把验证放到前端去了
}

AbsentReq(form['startDate'].value, days, form['stuStartTime'].value)


def AbsentReq(startdate, days, time):
    base = datetime.datetime.strptime(startdate, '%Y-%m-%d')
    date_list = [base + datetime.timedelta(days=x) for x in range(days)]
    dates = [x.strftime("%Y-%m-%d") + ' '+time+':00' for x in date_list]
    now = None
    after = None
    for i in dates:
        data['stuStartTime'] = i
        now = time.time()
        response = requests.post(
            'http://stu.gac.upc.edu.cn:8089/stuqj/addQjMess', headers=headers, data=data)
        if response.json()['resultStat'] == "success":
            print("content-type:text/html")
            print("")
            print('用时 {} s,请假时间为 {} 的请假已成功，返回为{}.'.format(
                time.time()-now, data['stuStartTime'], str(response.json())))
        else:
            print('用时 {} s,请假失败，返回为: {}'.format(time.time()-now,
                  response.json()['mess'], str(response.json())))
    # 返回值
    # 重复提交：{"resultStat":"error","mess":"您2021-03-16的请假信息已提交，请勿重复添加。","data":null,"othermess":null}
    # 成功提交：{"resultStat":"success","mess":"成功","data":1,"othermess":null}
    # 提交错误2：{"resultStat":"error","mess":"添加请假信息异常","data":"String index out of range: 10","othermess":null}
