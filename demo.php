<?php
$_SESSION['current_page'] = 'demo.php';

include('header.html');
include('session.php');

//CSV export data
$_SESSION['csv_query'] = "select * from demo";

// MySQL table
$opts['tb'] = 'demo';

// Name of field which is the unique key
$opts['key'] = 'codice';

// Type of key field (int/real/string/date etc.)
$opts['key_type'] = 'int';

// Sorting field(s)
$opts['sort_field'] = array('codice');

// Number of records to display on the screen
$opts['inc'] = 40;

// View Option
$opts['options'] = 'ACPVDF';

// Number of lines to display on multiple selection filters
$opts['multiple'] = '4';

// Navigation style
$opts['navigation'] = 'UG';

// Display special page elements
$opts['display'] = array(
	'form'  => true,
	'query' => false,
	'sort'  => true,
	'time'  => false,
	'tabs'  => true
);

// Set default prefixes for variables
$opts['js']['prefix']               = 'PME_js_';
$opts['dhtml']['prefix']            = 'PME_dhtml_';
$opts['cgi']['prefix']['operation'] = 'PME_op_';
$opts['cgi']['prefix']['sys']       = 'PME_sys_';
$opts['cgi']['prefix']['data']      = 'PME_data_';

/* Get the user's default language and use it if possible or you can
   specify particular one you want to use. Refer to official documentation
   for list of available languages. */
$opts['language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'] . '-UTF8';

// Log
$opts['logtable'] = 'changelog';

// Field definitions

$opts['fdd']['codice'] = array(
  'name'     => 'codice',
  'select'   => 'T',
  'maxlen'   => 19,
  'sort'     => true
);

$opts['fdd']['variabile1'] = array(
  'name'     => 'Variabile 1',
  'select'   => 'T',
  'maxlen'   => 19,
  'sort'     => true
);

$opts['fdd']['variabile2'] = array(
  'name'     => 'Allegati',
  'URL'	     => 'attach.php?att=$key&tab=demo&col=$name',
  'URLtarget' => '_blank',
  'URLdisp' => 'Allegati ($value)',
  'options'  => 'LFDV',
  'select'   => 'N',
  'sort'     => true
);

// Now important call to phpMyEdit
require_once 'phpMyEdit.class.php';
new phpMyEdit($opts);

include('footer.html')
?>
