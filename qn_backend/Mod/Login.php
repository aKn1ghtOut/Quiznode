<?php
	$user = htmlspecialchars($GLOBALS['postvar']["user"]);
	$pass = htmlspecialchars($GLOBALS['postvar']["pass"]);
	include $GLOBALS['root'] . '/qn_lib/mod_manage.php';
	$conne = qnDB_M::start();
	$res = qnDB_M::Login($user, $pass, $conne);
	qnDB_M::stop();
	if($res == 1)
		header("Location: " . $GLOBALS['host']);
	else
		header("Location: " . $GLOBALS['host'] . "/Mod/Login");
?>
