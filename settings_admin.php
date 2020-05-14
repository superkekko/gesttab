<?php

include('session.php');

$web_ver = '1.9.2';

$error     = "";

if (!isset($user)) {
    $user = $_SESSION['login_user'];
}


if (isset($_POST['usr']) & isset($_POST['email']) & isset($_POST['pages']) & isset($_POST['pwd']) & isset($_POST['enable']) & isset($_POST['admin']) & isset($_POST['csv_export']) & !isset($_GET['mod_usr_id'])) {
	$usr    = mysqli_real_escape_string($db, $_POST['usr']);
    $email  = mysqli_real_escape_string($db, $_POST['email']);
    $pages  = mysqli_real_escape_string($db, $_POST['pages']);
    $pwd    = mysqli_real_escape_string($db, $_POST['pwd']);
    $enable = mysqli_real_escape_string($db, $_POST['enable']);
    $admin  = mysqli_real_escape_string($db, $_POST['admin']);
    $csv_export  = mysqli_real_escape_string($db, $_POST['csv_export']);
    
    
    $sql_ver_usr = "select * from user where usr_id = '$usr'";
    $result_ver  = mysqli_query($db, $sql_ver_usr);
    $count       = mysqli_num_rows($result_ver);
    
    if ($count == 0) {
        $sql_usr = "insert into user (usr_id, email, passwd, pages_id, valid, admin, csv_export) values ('$usr', '$email', sha1('$pwd'), '$pages', '$enable', '$admin', '$csv_export')";
        mysqli_query($db, $sql_usr);
        $error = 'Utente inserito correttamente';
    } else {
        $error = 'Utente presente';
    }
}

if (isset($_POST['usr']) & isset($_POST['email']) & isset($_POST['pages']) & isset($_POST['pwd']) & isset($_POST['enable']) & isset($_POST['admin']) & isset($_POST['csv_export']) & isset($_GET['mod_usr_id'])) {
	$usr    = mysqli_real_escape_string($db, $_POST['usr']);
    $email  = mysqli_real_escape_string($db, $_POST['email']);
    $pages  = mysqli_real_escape_string($db, $_POST['pages']);
    $pwd    = mysqli_real_escape_string($db, $_POST['pwd']);
    $enable = mysqli_real_escape_string($db, $_POST['enable']);
    $admin  = mysqli_real_escape_string($db, $_POST['admin']);
    $csv_export  = mysqli_real_escape_string($db, $_POST['csv_export']);
    
    $sql_usr = "update user set email='$email', pages_id='$pages', valid='$enable', admin='$admin', csv_export='$csv_export' where usr_id='$usr'";
    mysqli_query($db, $sql_usr);
    
    if ($pwd <> '') {
        $sql_usr = "update user set passwd=sha1('$pwd') where usr_id='$usr'";
        mysqli_query($db, $sql_usr);
    }
    
    $page_name = basename($_SERVER['PHP_SELF']);
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . $page_name . '">';
}

if (isset($_GET['del_usr_id'])) {
    $usr_delete  = mysqli_real_escape_string($db, $_GET['del_usr_id']);
    $sql_del_usr = "delete from user where usr_id='$usr_delete'";
    mysqli_query($db, $sql_del_usr);
}

if (isset($_GET['mod_usr_id'])) {
    $usr_mod        = mysqli_real_escape_string($db, $_GET['mod_usr_id']);
    $sql_mod_usr    = "select * from user where usr_id='$usr_mod'";
    $result_usr_mod = mysqli_query($db, $sql_mod_usr);
    $row_usr_mod    = mysqli_fetch_array($result_usr_mod, MYSQLI_ASSOC);
}

$sql_list_usr    = "select * from user";
$result_list_usr = mysqli_query($db, $sql_list_usr);

?>


    <div>Aggiungi/Modifica utente</div>
    <form name="form_insert" method="post" action="settings.php
	<?php if (isset($_GET['mod_usr_id'])) {echo '?mod_usr_id=' . $row_usr_mod['usr_id'];};?>">
    <input type="text" name="usr" id="usr"
	<?php
	if (isset($_GET['mod_usr_id'])) {
		echo 'readonly="readonly" value="' . $row_usr_mod['usr_id'] . '"';
	} else {
		echo 'placeholder="Username"';
	};?>>
	<input type="password" name="pwd" id="pwd" placeholder="Password">
	<input type="email" name="email" id="email"
	<?php
	if (isset($_GET['mod_usr_id'])) {
		echo 'value="' . $row_usr_mod['email'] . '"';
	} else {
		echo 'placeholder="Email"';
	};?>>
	<input type="pages" name="pages" id="pages"
	<?php
	if (isset($_GET['mod_usr_id'])) {
		echo 'value="' . $row_usr_mod['pages_id'] . '"';
	} else {
		echo 'placeholder="Pagine (sep. ',')"';
	};?>>
	<select name="csv_export" id="csv_export" style="background-color: #FFFFFF; color: black;">
	<?php
	if (isset($_GET['mod_usr_id'])) {
		echo '<option value="' . $row_usr_mod['csv_export'] . '">';
		if ($row_usr_mod['csv_export'] == 'S') {
			echo 'Ex Abilitato</option>
							<option value=" ">CSV Disabilitato</option>';
		} else {
			echo 'Ex Disabilitato</option>
							<option value="S">CSV Abilitato</option>';
		};
	} else {
		echo '<option value="S">CSV Abilitato</option>
					<option value=" ">CSV Disabilitato</option>';
	};?></select>
	<select name="enable" id="enable" style="background-color: #FFFFFF; color: black;">
	<?php
	if (isset($_GET['mod_usr_id'])) {
		echo '<option value="' . $row_usr_mod['valid'] . '">';
		if ($row_usr_mod['valid'] == 'S') {
			echo 'Abilitato</option>
							<option value=" ">Disabilitato</option>';
		} else {
			echo 'Disabilitato</option>
							<option value="S">Abilitato</option>';
		};
	} else {
		echo '<option value="S">Abilitato</option>
					<option value=" ">Disabilitato</option>';
	};?></select>
	<select name="admin" id="admin" style="background-color: #FFFFFF; color: black;">
	<?php
	if (isset($_GET['mod_usr_id'])) {
		echo '<option value="' . $row_usr_mod['admin'] . '">';
		if ($row_usr_mod['admin'] == 'S') {
			echo 'Admin</option>
				  <option value="N">Utente</option>';
		} else {
			echo 'Utente</option>
				  <option value="S">Admin</option>';
		};
	} else {
		echo '<option value="S">Admin</option>
			  <option value="N">Utente</option>';
	};?></select>
	<input type="submit" name="submit" value="Applica">
    <?php echo $error;?>
    </form>
	
<br>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nome Utente</a></th>
            <th>Email</th>
            <th>Ultimo login</th>
			<th>Utente attivo</th>
			<th>Amministratore</th>
			<th>CSV abilitato</th>
			<th>Pagine</th>
			<th>Cancella | Modifica</th>
        </tr>
    </thead>
    <tbody>
	 <?php
while ($row_usr = mysqli_fetch_array($result_list_usr, MYSQLI_ASSOC)) {

    echo '<tr>
	   <td>' . $row_usr['usr_id'] . '</td>
	   <td>' . $row_usr['email'] . '</td>
	   <td>' . date('d/m/Y', strtotime($row_usr['tms_upd'])) . '</td>
	   <td>';
    if ($row_usr['valid'] == 'S') {
        echo 'Abilitato';
    } else {
        echo 'Disabilitato';
    }
    ;
    echo '</td>
	   <td>';
    if ($row_usr['admin'] == 'S') {
        echo 'Admin';
    } else {
        echo 'Utente';
    }
    ;
    echo '</td>
	<td>';
    if ($row_usr['csv_export'] == 'S') {
        echo 'Abilitato';
    } else {
        echo 'Disabilitato';
    }
    ;
    echo '</td>';
	echo '<td>'. $row_usr['pages_id'] . '</td>';
    if ($row_usr['usr_id'] == $user) {
        echo '<td>Cancella | <a href="?mod_usr_id=' . $row_usr['usr_id'] . '">Modifica</a></td></tr>';
    } else {
        echo '<td><a href="?del_usr_id=' . $row_usr['usr_id'] . '">Cancella</a> | <a href="?mod_usr_id=' . $row_usr['usr_id'] . '">Modifica</a></td></tr>';
    }
    ;
}
?>  
	</tbody>
</table>
	<br><br>
	<div>Pagine presenti:<br>
	<?php
	$sql_page   = "SELECT page_id, page_name, page_ref FROM pages";
	$result_page = mysqli_query($db, $sql_page);
	while ($row_page = mysqli_fetch_array($result_page, MYSQLI_ASSOC)) {
    	echo 'Pagina '. $row_page['page_id'] . ' (' . $row_page['page_name'] . ' - <a href="delete.php?att='.$row_page['page_name'].'">Cancella</a>);<br>';
	}
	?></div><br>
    <div><a href="_new.php" target="_blank">Crea nuova pagina</a> (<a href="./doc/index.html" target= "_blank">Guida</a>) (la tabella deve essere prima <a href="./adminer.php" target="_blank">inserita nel DB</a>).</div>
	<br>
	<div>Changelog:<br></div>
	<table class="table table-striped">
    <thead>
        <tr>
            <th>Tabella</th>
            <th>Colonna</th>
            <th>Vecchio valore</th>
			<th>Nuovo valore</th>
			<th>Utente</th>
			<th>Host</th>
			<th>Data agg.</th>
        </tr>
    </thead>
    <tbody>
	<?php
	$sql_page   = "select tab, col, oldval, newval, user, host, updated from changelog order by updated desc limit 5";
	$result_page = mysqli_query($db, $sql_page);
	while ($row_page = mysqli_fetch_array($result_page, MYSQLI_ASSOC)) {
    	echo '<tr>
	   <td>'. $row_page['tab'] . '</td>
	   <td>'. $row_page['col'] . '</td>
	   <td>'. $row_page['oldval'] . '</td>
	   <td>'. $row_page['newval'] . '</td>
	   <td>'. $row_page['user'] . '</td>
	   <td>'. $row_page['host'] . '</td>
	   <td>'. $row_page['updated'] . '</td>';
	}
	?>	</tbody>
</table>