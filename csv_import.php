<?php

include('header.html');
include('session.php');

$tab = $_SESSION['table'];

function quote($str) {
 if (preg_match('*[a-zA-z]*',$str)) {
  return sprintf("'%s'", $str);
 }
 elseif (preg_match('([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))',$str)) {
  return sprintf("'%s'", $str);
 }
 elseif ($str=='') {
  return sprintf("NULL", $str);
 }
 else {
  return $str;
 }
};

$log = '';

if(isset($_FILES['userfile']['tmp_name'])) {
 if(is_uploaded_file($_FILES['userfile']['tmp_name'])) {
  $file = $_FILES['userfile']['tmp_name'];
  $handle = fopen($file, "r");
  $i = 0;
 
  while(($filesop = fgetcsv($handle, 1000, ";")) !== false) {
   $escaped_values = array_map("mysql_real_escape_string", array_values($filesop));
   $quoted_values = array_map("quote", array_values($escaped_values));
   $values  = implode(", ", array_values($quoted_values));
   if ($i>0){
    $sql_value = "INSERT INTO $tab VALUES ($values)";
    $result_sql = mysqli_query($db, $sql_value);
	if (!$result_sql){
     $log .= "not loaded ".$values." (".mysqli_error($db).")<br>";
    }
   }
   $i=$i+1;
  }
 }
}
?>

<form enctype="multipart/form-data" action="csv_import.php" method="POST">
    <input type="hidden" name="destination" value="<?php echo $_SERVER["REQUEST_URI"]; ?>"/>
    <input type="file" name="userfile" />
    <input type="submit" value="Invia" />
</form>
<br>
<div>Il numero di colonne deve essere quello della tabella, deve essere lasciata la riga di intestazione.<br>
Le date devono essere nel formato YYYY-MM-GG e le cifre con il "." come separatore.</div>
<br>
<?php
    $sql   = "select max(id) as id from $tab";
	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	echo 'Il contatore: '.$row[id];
?>
<br>
<?php
  echo '<br>'.$log;
?>
</body>
</html>