<?php
$mainDB = new mysqli("localhost", "mymunin", "");
$mainDB->select_db("mymunin");

if ($mainDB->connect_error)
{
	print "Error connection to DB: ". mysqli_connect_error();
	exit;
}

define("INSTALL_DIR", $_SERVER['DOCUMENT_ROOT'] . "/mymunin");

define('SMARTY_DIR', INSTALL_DIR . '/libs/smarty/' );

require_once(SMARTY_DIR . 'Smarty.class.php');

$smarty = new Smarty;

$smarty->config_dir = SMARTY_DIR;
$smarty->template_dir = INSTALL_DIR ."/smarty/templates";
$smarty->compile_dir = INSTALL_DIR ."/smarty/templates_c";
$smarty->compile_check = TRUE;
$smarty->debugging = FALSE;
?>