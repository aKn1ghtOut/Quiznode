<?php
if(!isset($_SESSION['type']))
{
	session_start();
	if(!isset($_SESSION['type']))
		header("Location: " . $GLOBALS['host'] . '/Account/Login');
}
if($_SESSION['type']!='mod')
{
	echo "You are not authorized to do this.";
	die();
}
else
{
	if ((!isset($_POST['email']))||(!isset($_POST['name']))||(!isset($_POST['pass']))) {
		die("One or more parameters not found!");
	}
	include $GLOBALS['root'] . "/qn_lib/mod_manage.php";
	$conne = qnDB_M::start();
	$result = qnDB_M::createGroup(htmlspecialchars($_POST['name']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['pass']), $conne);
	//echo $result;
	if($result != 1)
		die('Error encountered. Error code: ' . $result);
	header("Location: " . $GLOBALS['host'] . "/Mod/Accounts") ;
}
?>