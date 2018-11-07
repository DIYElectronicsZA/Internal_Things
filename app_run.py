#!/usr/bin/env python

#import packages used
import cgi, cgitb
cgitb.enable()

form = cgi.FieldStorage()

#get values for appointment
appointment_name = form.getvalue('Name2')
appointment_email = form.getvalue('Email2')
appointment_order = form.getvalue('order_number2')
appointment_Time = form.getvalue('Time')
appointment_Date = form.getvalue('Date')
appointment_Technician = form.getvalue('Technician')

#set up html for displaying details entered
print("Content-Type: text/html;charset=utf-8")
print "Content-type:text/html\r\n\r\n"
print "<html>"
print "<head>"
print "<title>Hello - Second CGI Program</title>"
print "</head>"
print "<body>"
print "<h1 style='font-size:300%;'>Details for Appointment<h1>"
print "<br>"
print "<h2>Full Name: %s</h2>" % (appointment_name)
print "<h2>Ordern Number: %s</h2>" % (appointment_order)
print "<h2>Date: %s</h2>" % (appointment_Date)
print "<h2>Time: %s</h2>" % (appointment_Time)
print "<h2>Technician: %s</h2>" % (appointment_Technician)
print "</body>"
print "</html>"

def send_message_to_slack(name, email, order, Time, Date, Technician):
    """Function used to send message to slack channel"""
    import urllib2
    import json
    
    if name is None:
        name = "NA"
    if email is None:
        email = "NA"
    if order is None:
        order = "NA"
    if Time is None:
        Time = "NA"
    if Technician is None:
        Technician = "NA"

    #return details is string used to forward to slack
    return_details = "Appointment Booking:" + "\n" + "--------------------------------" + "\n\n" + "Full Name: " + name + "\n" + "Email: " + email + "\n" + "Order number: " + order + "\n\n" + "Date: " + Date + "\n" + "Time: " + Time + "\n" + "Technician: " + Technician
    post = {"text": "{0}".format(return_details)}

    try:
        json_data = json.dumps(post)
        req = urllib2.Request("",
                              data=json_data.encode('ascii'),
                              headers={'Content-Type': 'application/json'}) 
        resp = urllib2.urlopen(req)
    except Exception as em:
        print("EXCEPTION: " + str(em))
        
send_message_to_slack(appointment_name, appointment_email, appointment_order, appointment_Time, appointment_Date, appointment_Technician)