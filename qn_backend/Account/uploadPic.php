<?php
if(isset($_FILES["propic"])) {
if(!isset($_SESSION))
session_start();
if(!isset($_SESSION['type']))
die("Please log in first");
if($_SESSION['type']!="user")
exit("You can not do this action");
if((!isset($_SESSION['email']))||$_SESSION['email']=="")
exit("Authentication error. Please logout and then login");
$tarDir = $GLOBALS['root'] . '/qn_assets/';
$link = $GLOBALS['host'] . '/qn_assets/';
$Image = array(
				"set" => 0,
				"ext" => "",
				"nameAss" => "",
				"target" => "",
				"link" => ""
				);
if (file_exists($_FILES['propic']['tmp_name'])) {
	$name = $_FILES['propic']['name'];
	$Image['set'] = 1;
	$Image['ext'] = end((explode('.', $name)));
	if($Image['ext'] != "png"&&$Image['ext'] != "PNG"&&$Image['ext'] != "jpg"&&$Image['ext'] != "JPG"&&$Image['ext'] != "jpeg"&&$Image['ext'] != "JPEG")
		exit("Invalid Image");
	$Image['nameAss'] = md5(uniqid(rand(), true));
	$Image['target'] = $tarDir . $Image['nameAss'] .".". $Image['ext'];
	$Image['link'] = $link . $Image['nameAss'] .".". $Image['ext'];
	if(move_uploaded_file($_FILES['propic']['tmp_name'], $Image['target']))
		echo "";
	else
		die("Image not uploaded");
}
else
	exit("No profile picture submitted");
include_once $GLOBALS['root'].'/qn_lib/user_manage.php';
$conne = qnDB_U::start();
$sql = 'UPDATE qn_users SET propic="'.$Image['link'].'" WHERE u_email="'.$_SESSION['email'].'" ;';
$sqlRes = mysql_query($sql, $conne);
if(!$sqlRes)
	exit("Error. Try again Later.");
else
	exit("Success");
}
else
exit("No Image found");
?>