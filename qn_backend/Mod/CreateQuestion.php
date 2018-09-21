<?php
function setSalt($password)
{
	$ret = array(
				"password" => "",
				"salt" => ""
					);
	$ret['salt'] = md5(uniqid(rand(), true));
	$ret['password'] = hash("sha256", $ret['salt'].$password);
	return $ret;
}
if(!isset($_SESSION))
	session_start();
if((!isset($_SESSION['type']))||$_SESSION['type'] != "mod")
	die("You do not have the priveleges to do this");
if($_POST['Question'] == ""||$_POST['Answer'] == "")
	die("Question or Answer not provided");
include $GLOBALS['root'].'/qn_lib/mod_manage.php';
$ques = htmlspecialchars($_POST['Question']);
$ans = htmlspecialchars($_POST['Answer']);
if(!(isset($_POST['Hint']) && $_POST['Hint'] == ""))
$hint = htmlspecialchars($_POST['Hint']);
else
$hint = "";
$tarDir = $GLOBALS['root'] . '/qn_assets/';
$link = $GLOBALS['host'] . '/qn_assets/';
$Image = array(
				"set" => 0,
				"ext" => "",
				"nameAss" => "",
				"target" => "",
				"link" => ""
				);
$Audio = array(
				"set" => 0,
				"ext" => "",
				"nameAss" => "",
				"target" => "",
				"link" => ""
				);
if (file_exists($_FILES['Image']['tmp_name'])) {
	$name = $_FILES['Image']['name'];
	$Image['set'] = 1;
	$Image['ext'] = end((explode('.', $name)));
	$Image['nameAss'] = md5(uniqid(rand(), true));
	$Image['target'] = $tarDir . $Image['nameAss'] .".". $Image['ext'];
	$Image['link'] = $link . $Image['nameAss'] .".". $Image['ext'];
	if(move_uploaded_file($_FILES['Image']['tmp_name'], $Image['target']))
		echo "Success";
	else
		die("Image not uploaded");
}
if (file_exists($_FILES['Audio']['tmp_name'])) {
	$name = $_FILES['Audio']['name'];
	$Audio['set'] = 1;
	$Audio['ext'] = end((explode('.', $name)));
	$Audio['nameAss'] = md5(uniqid(rand(), true));
	$Audio['link'] = $link . $Audio['nameAss'] .".". $Audio['ext'];
	$Audio['target'] = $tarDir . $Audio['nameAss'] .".". $Audio['ext'];
	if(move_uploaded_file($_FILES['Audio']['tmp_name'], $Audio['target']))
		echo "Success";
	else
		die("Audio not uploaded");
}
$getAnsDet = setSalt($ans);
$conne = qnDB_M::start();
$sql = 'INSERT INTO qn_ques (Question, Answer, qn_salter, Hint, ImgURL, AudURL) VALUES ("'.
		$ques . '", "'.$getAnsDet["password"].'", "'.$getAnsDet["salt"] . '", "'.$hint.'", "'.$Image['link'].'", "'.$Audio['link'].'" );';
$sqlRes = mysqli_query($conne, $sql);
if(!$sqlRes)
die("SQL failed");
echo "Success";
?>