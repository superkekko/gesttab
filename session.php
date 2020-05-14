<?php
ini_set('session.save_path',realpath('./session'));

session_start();

include('config.php');

$user_check = $_SESSION['login_user'];
$page_check = $_SESSION['current_page'];

if ($page_check == 'nopage'){
$ses_sql = "select usr_id from user where usr_id = '$user_check'";
$result_sql = mysqli_query($db, $ses_sql);
$row = mysqli_fetch_array($result_sql, MYSQLI_ASSOC);
$login_session = $row['usr_id'];

} else {
$page_sql = "select page_id from pages where page_ref = '$page_check'";
$result_page_sql = mysqli_query($db, $page_sql);
$page_row = mysqli_fetch_array($result_page_sql, MYSQLI_ASSOC);
$page_id = $page_row['page_id'];

$ses_sql = "select usr_id from user where find_in_set($page_id, cast(pages_id as char)) > 0 and usr_id = '$user_check'";
$result_sql = mysqli_query($db, $ses_sql);
$row = mysqli_fetch_array($result_sql, MYSQLI_ASSOC);
$login_session = $row['usr_id'];
}

if (!isset($login_session)) {
    //echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
    header("location:index.php");
    exit;
}
?>