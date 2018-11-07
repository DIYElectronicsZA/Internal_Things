<html>
<body>
<?php
$fh = fopen("name_stock_general.txt", "r") or die("Unable to open file!"); 
$name_par = array();
while ($line = fgets($fh)) {
  //store name from test file in array
   $line = trim($line);
   array_push($name_par, $line);
}
fclose($fh);

$par_array = array();
foreach ($name_par as $value)
{
    //loop through names of products and create access variables for the names of products on reorder/par list
    $new_value = trim($value);
    $par = $_GET["$new_value"];
    //$par_array[$value] = $par;
    array_push($par_array,($par));
}    
  class MyDB extends SQLite3 {
      function __construct() {
         $this->open('mydb.db');
      }
   }
   $db = new MyDB();
   if(!$db) {
      echo $db->lastErrorMsg();
   } else {
      echo " <b> Opened database successfully</b>\n <br><br>";
   }
   //remove table initially incase there are new products added to text file.
    $statement = $db->prepare('DROP TABLE IF EXISTS par_levels');
    $result = $statement->execute();
    //recreate table with new values from text file
    $statement = $db->prepare('CREATE TABLE IF NOT EXISTS par_levels ( ID INTEGER PRIMARY KEY, Name TEXT, Par INT, UNIQUE(Name))');
    $result = $statement->execute();

    $contents = file('name_stock_general.txt');
    foreach($contents as $line) {
        $line = trim($line);  
    $word = "INSERT OR IGNORE INTO par_levels (Name) VALUES ('" .$line ."')"; //Insert product name
    //echo $word;
    $statement = $db->prepare($word);
    $result = $statement->execute();
    }
    
$loop_amount = (count($par_array)-1); //the amount of loops to complete according to size of product name list
$counted = count($par_array); //used to access unique ID in db to insert values
while ($loop_amount > -1)
{
    $for_par = "$par_array[$loop_amount]"; //par value entered in form now pushed to database
    $qry = $db->prepare('UPDATE par_levels SET PAR = :par_set WHERE ID= :count');
    $qry->bindParam(":par_set",$for_par);
    $qry->bindParam(":count", $counted);
    $qry->execute();
    $loop_amount = ($loop_amount - 1);
    $counted = ($counted - 1);
}

$statement = $db->prepare('SELECT * FROM par_levels');
$result = $statement->execute();
while ($row = $result->fetchArray()) {
    echo json_encode($row[1]), " updated" ;
    echo '<br>';
    
}

?>
</body>
</html>