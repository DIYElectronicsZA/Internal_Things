<!DOCTYPE html>
<html>
<body>

<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-llyw{background-color:#c0c0c0;border-color:inherit;text-align:left;vertical-align:top}
.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
.tg .tg-0lax{text-align:left;vertical-align:top}
.tg .tg-y6fn{background-color:#c0c0c0;text-align:left;vertical-align:top}
</style>

<center><h1 style="background-color:#52b848; color:#161616">Waltons Stock ReOrder Form</h1>
<p>Any inputs left blank will be assumed 0 stock.</p>
<p>To submit click the button at the bottom of the form and a message will be sent to Damian<p>
<form action="php_for_waltons.php" class = "ordering">
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
    $statement = $db->prepare('SELECT * FROM waltons_par');
    $result = $statement->execute();
    echo '<table class="tg">   <tr>
    <th class="tg-0pky">Product Description</th>
    <th class="tg-0pky">Par Levels</th>
    <th class="tg-0pky">On Hand</th>
  </tr>';
    while ($row = $result->fetchArray()) {
        $name_block = htmlspecialchars($row['1']);
        $quantity_block = htmlspecialchars($row['2']);
        echo  '<tr>' . 
        '<td class="tg-llyw">' .$name_block. '</td>'.
        '<td class="tg-llyw"><input type= "text" class= "par_edits" name ="' .$name_block. '" value="' .htmlspecialchars($row['2']). '" value="" readonly/></td>' .
        '<td class="tg-llyw"><input type= "number" name ="value_'.$name_block.'" value="" /></td></tr>';
    }
    echo '</table>

<input type="submit" value="Submit" class= "button button2">
</form>'
    
   ?>


</center>

</body>
</html>