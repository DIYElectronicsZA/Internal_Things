#!/usr/bin/env python
import sys
import cgi, cgitb
import sqlite3
import datetime
import time
import urllib2
import json
cgitb.enable()

print("Content-type: text/html\n\n");

# Load the data that PHP sent us
try:
    data = json.loads(sys.argv[1])
except:
    print ("ERROR")
    sys.exit(1)

    
result = data #python variable for array passed from php
dict_values = {} #empty dictionary to be used to match product name with par and values
file_object = open('name_stock_general.txt', 'r') #open file with names of products on general list
loop_time = 0
for line in file_object:
    """For loop used to gather names from txt file and match with corresponding [par, values] for json.loads"""
    line = line.rstrip("\n") 
    numerical_values = json.dumps(result[loop_time]) #get numerical values 
    loop_time = loop_time + 1
    dict_values[line] = (numerical_values) #match numerical values with names of products



message_string ="general stock to reorder: \n"
for key, value in dict_values.iteritems():
    """for loop used to calculate difference in par and values. 
    Values that require reordering are appended to string to send to slack"""
    value = value.replace("]", "")
    value = value.replace("[", "")
    value = value.replace('"', "")
    par, value = value.split(",")
    par = int(par)
    value = int(value)
    
    #print difference_in_par_value
    if value < par: #calculating difference
        re_order = (par - value)
        message_string = message_string + key + ": " + str(re_order) + "\n"
        
    
    #print key,par,value
def send_message_to_slack(message):
    """function to send message to slack"""
        
    message = message_string
    post = {"text": "{0}".format(message)}

    try:
        json_data = json.dumps(post)
        req = urllib2.Request("",
                              data=json_data.encode('ascii'),
                              headers={'Content-Type': 'application/json'}) 
        resp = urllib2.urlopen(req)
    except Exception as em:
        print("EXCEPTION: " + str(em))
        
send_message_to_slack(message_string)