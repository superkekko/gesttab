<?php
include ('header.html');
include('session.php');

if (isset($_GET['att'])){
 $att = mysqli_real_escape_string($db, $_GET['att']);
};
if (isset($_GET['tab'])){
 $tab = mysqli_real_escape_string($db, $_GET['tab']);
};
if (isset($_GET['col'])){
 $col = mysqli_real_escape_string($db, $_GET['col']);
};

if (isset($_GET['id'])){
 $id = mysqli_real_escape_string($db, $_GET['id']);
 $sql_del="delete from upload where id=$id";
 mysqli_query($db, $sql_del);
 
 $sql_2="update $tab x set x.$col=(select count(1) from upload u where u.table_id=x.id and u.tab='$tab')";
 mysqli_query($db, $sql_2);
};

 $currfile = $_FILES['userfile']['tmp_name'];
 $file_name = $_FILES['userfile']['name'];
 $file_type = $_FILES['userfile']['type'];
 $file_size = $_FILES['userfile']['size'];
 $file_error = $_FILES['userfile']['error'];

$link = '?att='.$att.'&tab='.$tab.'&col='.$col;

?>
<form enctype="multipart/form-data" action="attach.php<?php echo $link ?>" method="POST">
    <input type="hidden" name="destination" value="<?php echo $_SERVER["REQUEST_URI"]; ?>"/>
    <input type="file" name="userfile" />
    <input type="submit" value="Invia" />
</form>

<?php
if (is_uploaded_file($currfile)) {
  if (($file_size > 30000000)){      
     echo 'File troppo grande. Il file deve essere inferiore a 30Mb.'; 
  }
  elseif ($file_type == 'application/octet-stream'){
     echo 'Tipo di file non valido. Riprovare.';         
  }  
  else {
     $bin_data = addslashes(fread(fopen($currfile, "rb"), filesize($currfile)));
     $sql="INSERT INTO upload(file,type,size,data,tab,table_id) VALUES('$file_name','$file_type','$file_size','$bin_data','$tab','$att')";
     mysqli_query($db, $sql);
	 
	  $sql_2="update $tab x set x.$col=(select count(1) from upload u where u.table_id=x.codice and u.tab='$tab')";
      mysqli_query($db, $sql_2);
  };
};

?>

<br><br>

<?php
$sql_att = "select * from upload where table_id in ($att)";
$result_att = mysqli_query($db, $sql_att);

while($row_att = mysqli_fetch_array($result_att,MYSQLI_ASSOC)){
      echo '<a href="view.php?id='.$row_att['id'].'">'.$row_att['file'].'</a> (<a href="attach.php'.$link.'&id='.$row_att['id'].'">Delete</a>)<br>';
 };
?>

</body>
</html>
