<!DOCTYPE html>
<html>
<head>
</head>
<body>

<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-llyw{background-color:#c0c0c0;border-color:inherit;text-align:left;vertical-align:top}
.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
.tg .tg-0lax{text-align:left;vertical-align:top}
.tg .tg-y6fn{background-color:#c0c0c0;text-align:left;vertical-align:top}

.column {
    float: left;
    width: 33.33%;
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}

</style>
<div class="row">
<div class="column">
<p><b>To add or remove product:</b><br>(DO NOT USE WHITESPACES, use "_" instead)<br> If list does not update after Submit, refresh page</p>
<form id ="submitForm" action="change_product_list.py" onsubmit="setTimeout(function(){window.location.reload();},70)">
<fieldset style="background-color:#b7b7b7;">
  Choose list to edit:<br>
  <select name="list_to_edit"><br>
  <option value="Waltons">Waltons</option>
  <option value="General">General</option>
  </select><br><br>
  Add or Remove:<br>
  <select name="Add_or_remove"><br>
  <option value="Add">Add</option>
  <option value="Remove">Remove</option>
  </select><br><br>
  Product to add/remove:<br>
  <input type="text" name="product_name" value="" required /><br><br>
  <input type="submit" name= "return_sub" value="Submit" class= "button button2">
</fieldset>
</form>
</div>
<?php
//open text file containing waltons list
$handle = fopen("name_stock_waltons.txt", "r") or die("Unable to open file!");
//Building panel to display list with html
echo '<div class="column">';
echo '<b>Waltons List</b><br>';

if ($handle) {
    while (($line = fgets($handle)) !== false) {
        // line read and display in panel.
        echo $line;
        echo '<br>';
    }

    fclose($handle);
} else {
    // error opening the file.
} 
echo '</div>';

//open text file containing general list
$handle = fopen("name_stock_general.txt", "r") or die("Unable to open file!");
//Building panel to display list with html
echo '<div class="column">';
echo '<b>General List</b><br>';
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        // process the line read.
        echo $line;
        echo '<br>';
    }

    fclose($handle);
} else {
    // error opening the file.
} 
echo '</div>';
?>
</div>
<script>
$('#submitForm').submit(function () {
 sendContactForm();
 return false;
});
</script>
</body>
</html>
