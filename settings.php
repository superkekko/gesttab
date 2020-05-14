<?php

$_SESSION['current_page'] = 'nopage';

include('session.php');
include('header.html');

if (!isset($user)) {
    $user = $_SESSION['login_user'];
}

$sql_admin    = "select * from user where usr_id='$user' and admin='S'";
$result_admin = mysqli_query($db, $sql_admin);
$count_admin  = mysqli_num_rows($result_admin);
?>

<?php
if ($count_admin == 1) {
    include('settings_admin.php');
}

include('footer.html')
?>
