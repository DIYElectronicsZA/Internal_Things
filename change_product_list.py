#!/usr/bin/env python

#import packages
import cgi, cgitb
print("Content-type: text/html\n\n")

cgitb.enable()

form = cgi.FieldStorage()

#pull values from html/php page
list_to_edit = form.getvalue('list_to_edit')
Add_or_remove = form.getvalue('Add_or_remove')
product_name = form.getvalue('product_name')
product_name = product_name.strip()
product_name = str(product_name)
product_name = product_name.lower()

#determine which list needs to be editted
if list_to_edit == "Waltons":
    print "Waltons Stock"
    filename = "name_stock_waltons.txt"
else:
    print "General Stock"
    filename = "name_stock_general.txt"


#open file and read lines
file = open(filename, 'r')
lines = file.readlines()
file.close()

#determine if product needs to be added or removed from selected list
if Add_or_remove == 'Add':
    file = open(filename, 'a')
    file.write(product_name + "\n")
    file.close()
else:
    file2 = open(filename, "w")
    for line in lines:
        line = line.strip()
        line = line.lower()
        if str(line) == product_name:
            continue
        else:
            file2.write(line)
            file2.write("\n")
            
    file2.close()
