#!/usr/bin/env python

import cgi, cgitb
import sqlite3
import datetime
import time
from trello import TrelloClient
cgitb.enable()

form = cgi.FieldStorage()
returns_job = form.getvalue('job_num')

#Get values from html using CGI
returns_name = form.getvalue('Name')
returns_email = form.getvalue('Email')
returns_contact = form.getvalue('Contact')
returns_address = form.getvalue('address')
returns_order = form.getvalue('order_number')
returns_reason = form.getvalue('Reason')
returns_action = form.getvalue('Action')
returns_ticket = form.getvalue('ticket_number')

#Display inputs in HTML format
print("Content-Type: text/html;charset=utf-8")   
print "Content-type:text/html\r\n\r\n"
print "<html>"
print "<head>"
print "<title>Hello - Second CGI Program</title>"
print "</head>"
print "<body>"
print "<h1 style='font-size:300%;'>Details for Return<h1>"
print "<br>"
print "<h2>Job Number: %s</h2>" % (returns_job)
print "<h2>Name: %s</h2>" % (returns_name)
print "<h2>Email: %s</h2>" % (returns_email)
print "<h2>Contact Number: %s</h2>" % (returns_contact)
print "<h2>Address: %s</h2>" % (returns_address)
print "<h2>Order Number: %s</h2>" % (returns_order)
print "<h2>Ticket Number: %s</h2>" % (returns_ticket)
print "<h2>Reason: %s</h2>" % (returns_reason)
print "<h2>Action: %s</h2>" % (returns_action)
print "</body>"
print "</html>"

def store_in_database():
    # Create a database in RAM
    db = sqlite3.connect(':memory:')
    # Creates or opens a file called mydb with a SQLite3 DB
    db = sqlite3.connect('mydb.db')


    cursor = db.cursor()
    job_number = returns_job
    name = returns_name
    email = returns_email
    phone = returns_contact
    address = returns_address
    order_number = returns_order
    ticket_number = returns_ticket
    reason = returns_reason
    action = returns_action
    date = '{:%Y-%m-%d %H:%M:%S}'.format(datetime.datetime.now())

#    # Get a cursor object
#    cursor = db.cursor()
#    cursor.execute('''DROP TABLE users''')
#    db.commit()

    cursor.execute('''
        CREATE TABLE IF NOT EXISTS users(name TEXT, email TEXT unique, phone TEXT)
    ''')
    db.commit()

    cursor.execute('''
        CREATE TABLE IF NOT EXISTS returns(id INTEGER PRIMARY KEY AUTOINCREMENT, email TEXT , date TEXT, order_number TEXT, ticket_number TEXT, reason TEXT, action TEXT)
    ''')
    db.commit()
    
    cursor.execute('''
        INSERT OR REPLACE INTO users(name, email, phone)
        VALUES(?,?,?)''', (name, email, phone))
    db.commit()

    cursor.execute('''
        INSERT OR IGNORE INTO returns(email, date, order_number, ticket_number, reason, action)
        VALUES(?,?,?,?,?,?)''', (email, date, order_number, ticket_number, reason, action))
    db.commit()

    db.close()
    
def send_message_to_slack(job, name, email, contact, address, order, ticket, reason, action):
    """Send message in slack as well as add trello card"""
    import urllib2
    import json
    
    if job is None:
        job = "NA"
    if name is None:
        name = "NA"
    if order is None:
        order = "NA"
    if email is None:
        email = "NA"
    if contact is None:
        contact = "NA"
    if address is None:
        address = "NA"
    if ticket is None:
        ticket = "NA"
    if reason is None:
        reason = "NA"
    if action is None:
        action = "NA"
        
    return_details = "Over The Counter Returns:" + "\n" + "--------------------------------" + "\n\n" + "Job Number: " + job + "\n" + "Full Name " + name + "\n" + "Email: " + email + "\n" + "Contact Number: " + contact + "\n" + "Address: " + address + "\n" + "Order number: " + order + "\n" + "Ticket Number: " + ticket + "\n\n" + "Reason: " + reason + "\n" + "Action: " + action
    post = {"text": "{0}".format(return_details)}

    try:
        json_data = json.dumps(post)
        req = urllib2.Request("",
                              data=json_data.encode('ascii'),
                              headers={'Content-Type': 'application/json'}) 
        resp = urllib2.urlopen(req)
    except Exception as em:
        print("EXCEPTION: " + str(em))

    client = TrelloClient(
    api_key='',
    api_secret='',
    token='',
    token_secret='None',
    )

    trello_name = (" Job No: " + job + "-" + name)
    trello_descr = ( "Order Number: " + order + "\n" + "Name: " + name + "\n" + "Contact number: " + contact + "\n" + "Email: " + email + "\n" + "Ticket num: " + ticket)
    all_boards = client.list_boards()
    last_board = all_boards[1]
    lists = last_board.list_lists()
    for l in lists:
        if l.name == 'Repairs':
            card = l.add_card(trello_name, desc = trello_descr)
            items=['Assesment started', 'Assesment Complete/ Job card filled out', 'Quotation sent/Customer advised','Warranty job (repair/refund/replace)', 'Quote Accepted', 'Quote Rejected', 'Waiting on parts', 'Repair Started', 'Repair Complete (QC and testing done, if applicable)', 'Ready for Collection/Sent to dispatch/Customer notified']
            card.add_checklist("Check", items, itemstates=None)
            

        
store_in_database()               
send_message_to_slack(returns_job, returns_name, returns_email, returns_contact, returns_address, returns_order, returns_ticket, returns_reason,returns_action)


