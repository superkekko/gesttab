<?php
ini_set('session.save_path',realpath('./session'));

session_start();


$_SESSION['current_page'] = 'nopage';

include('config.php');
include('header.html');

$error = "";

$sql_page   = "SELECT page_id, page_name, page_ref FROM pages";
$result_page = mysqli_query($db, $sql_page);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form 
    
    $myusername = mysqli_real_escape_string($db, $_POST['username']);
    $mypassword = mysqli_real_escape_string($db, $_POST['password']);
    $page = mysqli_real_escape_string($db, $_POST['page']);
    
    $sql    = "SELECT usr_id FROM user WHERE usr_id = '$myusername' and passwd = sha1('$mypassword') and valid = 'S' and find_in_set($page, cast(pages_id as char)) > 0";
    $result = mysqli_query($db, $sql);
    $row    = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
    $count = mysqli_num_rows($result);
    
    // If result matched $myusername and $mypassword, table row must be 1 row
    
    if ($count == 1) {
        //session_register("myusername");
        $_SESSION['login_user'] = $myusername;
        
        $sql_1 = "UPDATE user SET tms_upd = now() WHERE usr_id = '$myusername'";
        mysqli_query($db, $sql_1);
        
        //echo '<META HTTP-EQUIV="Refresh" Content="0; URL=monmev.php">';
        
        $sql    = "SELECT page_ref FROM pages WHERE page_id = '$page'";
    	$result = mysqli_query($db, $sql);
    	$row    = mysqli_fetch_array($result, MYSQLI_ASSOC);
        
        header("location: $row[page_ref]");
        
    } else {
        $error = '<br><br>Errore: Impossibile autenticarsi.';
    }
}
?>

  <div align="center">
      <form name="form_login" method="post" action="index.php">
          <h2>Monitoraggio Tabelle</h2>
            <input name="username" type="text" id="user_id" class="form-control" placeholder="username">
            <input type="password" name="password" id="password" class="form-control" placeholder="password">
            <select name="page" type="page" style="background-color: #FFFFFF; color: black;" class="form-control">
			<?php
			while ($row_page = mysqli_fetch_array($result_page, MYSQLI_ASSOC)) {
    			echo '<option value="' . $row_page['page_id'] . '">' . $row_page['page_name'] . '</option>';
		    	}
		    ?>
            <input type="submit" name="submit" value="Invia" class="btn btn-default">
            <?php echo $error;?>
      </form>
  </div>
</body>
</html>
