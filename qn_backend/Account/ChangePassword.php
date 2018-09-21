<?php
if(!isset($_SESSION))
session_start();
if(!isset($_SESSION['type']))
die("Please log in first");
if ((!isset($_POST['pass1']))||(!isset($_POST['pass2']))) {
	die("Parameters missing");
}
if ($_SESSION['type'] == "mod") {

	include $GLOBALS['root'] . "/qn_lib/mod_manage.php";
	$conne = qnDB_M::start();
	$sql = 'SELECT * FROM qn_mods WHERE mod_email="'.$_SESSION['email'].'" AND mod_pass="'.md5($_POST['pass1']).'" ;';
	$sqlRes = mysqli_query($sql, $conne);
	if(!$sqlRes)
		exit("Error: " . mysqli_error($conne));
	if(mysqli_num_rows($sqlRes) == 1)
	{
		$sql2 = 'UPDATE qn_mods SET mod_pass="'.md5($_POST['pass2']).'" WHERE mod_email="'.$_SESSION['email'].'" ;';
		$sqlRes2 = mysqli_query($sql2, $conne);
		if(!$sqlRes2)
			exit("Couldn't change password: ". mysqli_error($conne));
	}
}
else
{
	include $GLOBALS['root'] . "/qn_lib/user_manage.php";
	$conne = qnDB_U::start();
	$sql = array(

	    'SELECT * FROM qn_users WHERE u_email="'.$_SESSION['email'].'" AND u_pass="'.md5($_POST['pass1']).'" ;' ,

        'SELECT * FROM qn_groups WHERE group_email="'.$_SESSION['email'].'" AND group_pass="'.md5($_POST['pass1']).'" ;'
    ) ;
	$sqlRes = array(mysqli_query($conne), mysqli_query($sql[1], $conne), $sql[0]);
	if((!$sqlRes[0])||(!$sqlRes[1]))
		exit("Error: " . mysqli_error($conne));
	if(mysqli_num_rows($sqlRes[0]) == 1)
	{
		$sql2 = 'UPDATE qn_users SET u_pass="'.md5($_POST['pass2']).'" WHERE u_email="'.$_SESSION['email'].'" ;';
		$sqlRes2 = mysqli_query($sql2, $conne);
		if(!$sqlRes2)
			exit("Couldn't change password: ". mysqli_error($conne));
	}
	elseif (mysqli_num_rows($sqlRes[1]) == 1)
	{
		$sql2 = 'UPDATE qn_groups SET group_pass="'.md5($_POST['pass2']).'" WHERE group_email="'.$_SESSION['email'].'" ;';
		$sqlRes2 = mysqli_query($sql2, $conne);
		if(!$sqlRes2)
			exit("Couldn't change password: ". mysqli_error($conne));
	}
	exit("Changed");
}