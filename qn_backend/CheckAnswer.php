<?php
function getAns($password, $salt)
{
	$ret = array(
				"password" => "",
				"salt" => ""
					);
	$ret['salt'] = $salt;
	$ret['password'] = hash("sha256", $salt.$password);
	return $ret['password'];
}
if(!isset($_SESSION))
	session_start();
if((!isset($_SESSION['type']))||$_SESSION['type'] != "user")
	exit("Not Logged In");
if(!isset($_POST['Answer']))
	exit("No Answer Provided");
$qid = $_SESSION['score'] + 1;
$Answer = $_POST['Answer'];
include $GLOBALS['root'] . "/qn_lib/user_manage.php";
$conne = qnDB_U::start();
$sqlScore = 'SELECT score FROM qn_users WHERE u_email="'.$_SESSION['email'].'";';
$scoreRes = mysql_query($sqlScore, $conne);
$score = mysql_fetch_assoc($scoreRes, MYSQL_ASSOC);
$score = $score['score'];
if($_SESSION['score'] != $score)
{
	$_SESSION['score'] = $score;
	exit('Please reload.');
}
$sqlRes = mysql_query('UPDATE qn_users SET currTries = currTries + 1 WHERE u_email="' . $_SESSION['email'] . '" ;', $conne);
$sql = "SELECT * FROM qn_ques WHERE q_id=" . $qid . ';';
$sqlRes = mysql_query($sql, $conne);
$qDetails = mysql_fetch_assoc($sqlRes, MYSQL_ASSOC);
$saltedAns = getAns($_POST['Answer'], $qDetails['qn_salter']);
if($saltedAns == $qDetails['Answer'])
{
	$_SESSION['score'] = $_SESSION['score'] + 1;
	$sql = "UPDATE qn_users SET score=".$_SESSION['score'].', currQ=NOW(), qTime=' . time() . ', lastTries = currTries, currTries=0 WHERE u_email="' . $_SESSION['email'] . '" ;';
	$sqlRes = mysql_query($sql, $conne);
	qnDB_U::stop();
	if(!$sqlRes)
		exit("Please try again later.");
	else
		exit("Correct");
}
qnDB_U::stop();
if ($_SESSION['score'] == 0) {
	exit("Answer is incorrect");
}
else
{
	exit("Incorrect Answer");
}
?>