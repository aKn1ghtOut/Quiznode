<?php
	$user = htmlspecialchars($_POST["user"]);
	$pass = htmlspecialchars($_POST["pass"]);
	include $GLOBALS['root'] . '/qn_lib/user_manage.php';
	$conne = qnDB_U::start();
	$res = qnDB_U::Login($user, $pass, $conne);
	qnDB_U::stop();
	if($res == 1)
		exit("Logged In");
	else
		exit("Wrong Email/Password Combination");
?>