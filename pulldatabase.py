#!/usr/bin/env python

import cgi, cgitb
import sqlite3
import datetime
import time
from trello import TrelloClient
cgitb.enable()

form = cgi.FieldStorage()

print("Content-Type: text/html;charset=utf-8")   
print "Content-type:text/html\r\n\r\n"
print "<html>"
print "<head>"
print "</body>"
print "</html>"


form = cgi.FieldStorage()

db_search_by = form.getvalue('db_features')
db_search_column = form.getvalue('search_value')

db = sqlite3.connect(':memory:')
# Creates or opens a file called mydb with a SQLite3 DB
db = sqlite3.connect('mydb.db')


if db_search_by == "name":
    cursor = db.cursor()
    symbol = db_search_column
    field_to_search = 'name'
    cursor.execute("SELECT * FROM users WHERE %s = '%s'" % (field_to_search, symbol))
    results = cursor.fetchall()
    email_user = results[0][1]

    cursor.execute("SELECT * FROM returns WHERE email = '%s'" % (email_user))
    results = cursor.fetchall()
    print "name", results[0]

elif db_search_by == "email":
    cursor = db.cursor()
    symbol = db_search_column
    field_to_search = 'email'
    cursor.execute("SELECT * FROM users WHERE %s = '%s'" % (field_to_search, symbol))
    results = cursor.fetchall()
    print "email", results

    cursor.execute("SELECT * FROM returns WHERE email = '%s'" % (symbol))
    results = cursor.fetchall()
    print "email2", results
    
elif db_search_by == "order_number":
    cursor = db.cursor()
    symbol = db_search_column
    field_to_search = 'order_number'


    cursor.execute("SELECT * FROM returns WHERE order_number = '%s'" % (symbol))
    results = cursor.fetchall()
    order_number_email = results[0][1]
    print "order_2", results

    cursor.execute("SELECT * FROM users WHERE email = '%s'" % (order_number_email))
    results = cursor.fetchall()
    print "order_number" ,results
    
elif db_search_by == "ticket_number":
    cursor = db.cursor()
    symbol = db_search_column
    field_to_search = 'ticket_number'


    cursor.execute("SELECT * FROM returns WHERE ticket_number = '%s'" % (symbol))
    results = cursor.fetchall()
    ticket_number_email = results[0][1]
    print "ticket_2", results

    cursor.execute("SELECT * FROM users WHERE email = '%s'" % (ticket_number_email))
    results = cursor.fetchall()
    print "ticket_number" ,results
    
elif db_search_by == "contact_number":
    cursor = db.cursor()
    symbol = db_search_column
    field_to_search = 'order_number'

    cursor.execute("SELECT * FROM users WHERE phone = '%s'" % (symbol))
    results = cursor.fetchall()
    contact_number_email = results[0][1]
   
    cursor.execute("SELECT * FROM returns WHERE email = '%s'" % (contact_number_email))
    results = cursor.fetchall()
    
    print "contact", type(results)
    for result in results:
        print ("id")
        print (result[0])
        print "<br>"
        print "email"
        print (result[1])


