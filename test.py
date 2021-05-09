#!python
#coding:utf-8
import requests
import json
import time
import datetime
import cgi

fo = open("test1.txt", "wb")
fo.write("abc")
fo.close()

form = cgi.FieldStorage()
days = form['times'].value

fo = open("test.txt", "wb")
fo.write("abc")
fo.close()

print(days)