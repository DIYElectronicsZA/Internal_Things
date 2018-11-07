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
<center><h1 style="background-color:#52b848; color:#161616">Par Level Adjustment Form</h1>
<p>Adjust par values, which will be submitted to a database and stored for use by the ReOrder form.<br> Changes made to Par levels are persistent</p>
<form action="par_waltons.php" class = "ordering">
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
      echo "Opened database successfully\n";

   }
   
   //delete table in case there are new values in text file
    $statement = $db->prepare('DROP TABLE IF EXISTS par_levels');
    $result = $statement->execute();
    //recreate table with new products from text file
    $statement = $db->prepare('CREATE TABLE IF NOT EXISTS par_levels ( ID INTEGER PRIMARY KEY, Name TEXT, Par INT, UNIQUE(Name))');
    $result = $statement->execute();

    $contents = file('name_stock_general.txt');
    foreach($contents as $line) {
        $line = trim($line);  
    $word = "INSERT OR IGNORE INTO par_levels (Name) VALUES ('" .$line ."')"; //add new products to db
    $statement = $db->prepare($word);
    $result = $statement->execute();
    }
    $statement = $db->prepare('SELECT * FROM par_levels');
    $result = $statement->execute();
    echo "<table class='tg'>   <tr>
    
    <th class='tg-0pky'>Product Description</th>
    <th class='tg-0pky'>Par Levels</th>
  </tr>";
  
  //build table from text file in html table format
    while ($row = $result->fetchArray()) {
        $name_block = htmlspecialchars($row['1']);
        $quantity_block = htmlspecialchars($row['2']);
        echo  '<tr>' . 
        '<td class="tg-llyw">' .$name_block. '</td>'.
        '<td class="tg-llyw"><input type= "number" name ="' .$name_block. '" value="' .htmlspecialchars($row['2']). '" value=""/></td>' ;
    }
    echo '</table>

<input type="submit" value="Submit" class= "button button2">
</form>'
    
?>
</center>
</body>
</html>