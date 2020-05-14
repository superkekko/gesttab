<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'gesttab');
define('DB_PASSWORD', 'gesttab');
define('DB_DATABASE', 'gesttab');

$opts['hn'] = 'localhost';
$opts['un'] = 'gesttab';
$opts['pw'] = 'gesttab';
$opts['db'] = 'gesttab';

$db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$link = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD)
    OR die(mysql_error());

?>
