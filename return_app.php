<!DOCTYPE html>
<html>
<head>
<title>Returns and Appointments Form</title>
</head>
<body>

<style>
.content {
    width: 85%;
    margin: auto;
    font-weight:bold;
    font-family: 'Roboto', sans-serif;
}

body {
background-color: #d3d3d3
}




label {
  /* To make sure that all labels have the same size and are properly aligned */
  display: inline-block;
  width: 90px;
  text-align: right;
}

input, textarea {
  /* To make sure that all text fields have the same font settings
     By default, textareas have a monospace font */
  font: 1em sans-serif;

  /* To give the same size to all text fields */
  width: 200px;
  box-sizing: border-box;

  /* To harmonize the look & feel of text field border */
  border: 1px solid #999;
}

input:focus, textarea:focus {
  /* To give a little highlight on active elements */
  border-color: #000;
}

textarea {
  /* To properly align multiline text fields with their labels */
  vertical-align: top;

  /* To give enough room to type some text */
  height: 5em;
}

.button {
  /* To position the buttons to the same position of the text fields */
  color: #161616;
  font-weight:bold;
  background-color: #52b848;
}

.button {
  /* This extra margin represent roughly the same space as the space
     between the labels and their text fields */
  margin-left: .5em;
  border-radius: 4px;
  border: 2px solid #161616; /* Green */
}

.button2:hover {
    box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
    background-color:#161616;
    color:#52b848
}
</style>

<div class= "content">
<div style="float:left; display:inline-block; width:35%;text-align:center;">
<h1 style="background-color:#52b848; color:#161616">Returns</h1>
<form action="run.py" onsubmit="return_sub.disabled = true; return true;">
<fieldset style="background-color:#b7b7b7;">

<?php
  class MyDB extends SQLite3 {
      function __construct() {
         $this->open('mydb.db');
      }
   }
   $db = new MyDB();
   if(!$db) {
      echo $db->lastErrorMsg();
   } else {
      echo "";

   }

    $statement = $db->prepare('SELECT * FROM returns');
    $result = $statement->execute();

    while ($row = $result->fetchArray()) {
        $job_numer_block = htmlspecialchars($row['0']);
            }
    try {
        $job_numer_block = $job_numer_block + 1;
    } 
    catch(Exception $e) { $job_numer_block = 1;
    } 
    echo 'Job Number/ID<br>';
    echo '<input type="number" name ="job_num" value="' .$job_numer_block. '" readonly="readonly" ><br>';
 
?>

  Name and Surname:<br>
  <input type="text" name="Name" value="" required /><br><br>
  Email:<br>
  <input type="text" name="Email" value="" required /><br><br>
  Contact number:<br>
  <input type="number" name="Contact" value=""><br><br>
  Address:<br>
  <textarea type="text" name="address" value=""></textarea><br><br>
  Order Number:<br>
  <input type="text" name="order_number" value="" required /><br><br>
  Ticket Number:<br>
  <input type="number" name="ticket_number" value=""><br><br>
  Fault:<br>
  <textarea name="Reason" value="" cols="25" rows="5"></textarea><br><br>
  Additional:<br>
  <textarea name="Action" value="" cols="25" rows="5"></textarea><br><br>
  <input type="submit" name= "return_sub" value="Submit" class= "button button2" />
</fieldset>
</form>
</div>



<div style="display:inline; width:35%;text-align:center;float:right;">
<h1 style="background-color:#52b848; color:#161616">Appointments</h1>
<form action="app_run.py" onsubmit="appointment_submit.disabled = true; return true;">
<fieldset style="background-color:#b7b7b7;">
  Name and Surname:<br>
  <input type="text" name="Name2" value="" required /><br><br>
  Email:<br>
  <input type="text" name="Email2" value="" required /><br><br>
  Ticket Number:<br>
  <input type="number" name="order_number2" value=""><br><br>
  Booked Time(HH:MM:AM/PM):<br>
  <input type="time" name="Time" value="" min="9:00" max="18:00" required /><br><br>
  <input type="date" name="Date" value="" required /><br><br>
  Appointment with:<br>
  <select name="Technician"><br>
  <option value="Kyle">Kyle</option>
  <option value="Phil">Phil</option>
  <option value="Charl">Charl</option>
  <option value="Ben">Ben</option>
  <option value="Damian">Damian</option>
  <option value="Other">Other</option>
  </select><br><br>
  Additional info:<br>
  <textarea name="Addinfo" value="" cols="25" rows="5"></textarea><br><br><br><br><br><br>      
  <input type="submit" name= "appointment_submit" value="Submit" class= "button button2" />
  </fieldset>
</form>
  </div>
  
  <div style= "margin-left: 42%; float:center;">
<img src="DIYE Logo_Colour.jpg" style=" width:30%;display:inline-block; margin:auto; float:center;" />
</div>
    </div>
    
    
</body>
</html>

