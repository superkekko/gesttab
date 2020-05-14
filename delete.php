<?php
include ('header.html');
include('session.php');

if (isset($_GET['att'])){
 $att = mysqli_real_escape_string($db, $_GET['att']);
 $att = 'p_'.$att.'.php';
 
 unlink($att);
 $sql_del="delete from pages where page_ref='$att'";
 echo $sql_del;
 mysqli_query($db, $sql_del);
};
?>

</body>
</html>

