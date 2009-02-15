<?php
$mainDB = mysql_connect("localhost", "mymunin", "");
mysql_select_db("mymunin");

define("INSTALL_DIR", $_SERVER['DOCUMENT_ROOT'] . "/mymunin");

define('SMARTY_DIR', INSTALL_DIR . '/libs/smarty/' );

require_once(SMARTY_DIR . 'Smarty.class.php');

$smarty = new Smarty;

$smarty->config_dir = SMARTY_DIR;
$smarty->template_dir = INSTALL_DIR ."/smarty/templates";
$smarty->compile_dir = INSTALL_DIR ."/smarty/templates_c";
$smarty->compile_check = TRUE;
$smarty->debugging = TRUE;
?>