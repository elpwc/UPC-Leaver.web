# -*- coding: UTF-8 -*-
import os
import json
from flask_cors import *
os.environ['NLS_LANG'] = 'SIMPLIFIED CHINESE_CHINA.UTF8'
from flask import Flask,request
app = Flask(__name__)
 
@app.route('/upcleaver', methods=['GET','POST'])
def getcontent():

if __name__ == '__main__':
    app.run(host='124.156.135.18', port=5590)
    