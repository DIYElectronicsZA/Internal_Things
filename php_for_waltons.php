<html>
<body>
<?php

$fh = fopen("name_stock_waltons.txt", "r") or die("Unable to open file!"); 
//open file containing product list  to pull values from form
$name_stock = array();
//array tos tore names to be used to pull values from form
while ($line = fgets($fh)) 
{
  //store name in array
   array_push($name_stock, $line);
}
fclose($fh);

$par_array = array();
//int array to store (par numbers)[0] and (value numbers)[1]
foreach ($name_stock as $value)
{
    $new_value = trim($value); //clear end whitespace
    //$par_name = $new_value ."_par"; 
    $value_name = "value_" .$new_value;
    $par = $_GET["$new_value"]; //used to get par numbers
    $value = $_GET["$value_name"]; //used to get value numbers according to html name
    if ($value  == "")
        {
        $value = 0;
        }
    array_push($par_array, array($par, $value)); //append (par numbers)[0] and (value numbers)[1]
    

}    
 
 //access db 
  class MyDB extends SQLite3 {
      function __construct() {
         $this->open('mydb.db');
      }
   }
   $db = new MyDB();
   if(!$db) {
      echo $db->lastErrorMsg();
   } else {
      echo "<b>Stock list successfully forwarded to ReOrder Calculator";
   }



//method used to pass array to python script to do calculations and send messgae
$result = system('python reorder_cal_waltons.py ' . escapeshellarg(json_encode($par_array)),$result);
$resultData = json_decode($result, true);

var_dump($resultData);
?>
</body>
</html>