<?php
/*
this is db.php file, it will initiates a connection to the database
*/
//editing our configurational variables
$dbuser='root';
$dbname='login_system';
$dbpassword='';
$dbhost='localhost';

//defining the root for the database
if(!defined('ADMIN_DB_DIR'))
	define('ADMIN_DB_DIR', dirname(__FILE__));

require_once ADMIN_DB_DIR.'/ez_sql_core.php';
require_once ADMIN_DB_DIR.'/ez_sql_mysql.php';

global $db;
$db = new ezSQL_mysql($dbuser,$dbpassword,$dbname,$dbhost);
?>