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
$scoreRes = mysqli_query($conne, $sqlScore);
$score = mysqli_fetch_assoc($scoreRes);
$score = $score['score'];
if($_SESSION['score'] != $score)
{
	$_SESSION['score'] = $score;
	exit('Please reload.');
}
$sqlRes = mysqli_query($conne, 'UPDATE qn_users SET currTries = currTries + 1 WHERE u_email="' . $_SESSION['email'] . '" ;');


$sql = "SELECT * FROM qn_ques WHERE q_id=" . $qid . ';';
$sqlRes = mysqli_query($conne, $sql);
$qDetails = mysqli_fetch_assoc($sqlRes);
$saltedAns = getAns($_POST['Answer'], $qDetails['qn_salter']);
if($saltedAns == $qDetails['Answer'])
{
	$_SESSION['score'] = $_SESSION['score'] + 1;
	$sql = "UPDATE qn_users SET score=".$_SESSION['score'].', currQ=NOW(), qTime=' . time() . ', lastTries = currTries, currTries=0 WHERE u_email="' . $_SESSION['email'] . '" ;';
	$sqlRes = mysqli_query($conne, $sql);
	qnDB_U::stop();
	if(!$sqlRes)
		exit("Please try again later.");
	else
		exit("Correct");
}
$sql_try_dets = "SELECT * FROM qn_tries WHERE q_no=" . $qid . ' AND user_id=' . $_SESSION['user_id'] . ";";
$tries_query = mysqli_query($conne, $sql_try_dets);
if(mysqli_num_rows($tries_query) < 1)
{
    $temp_res = mysqli_query($conne, "INSERT INTO qn_tries (user_id, q_no, wrongTries) VALUES (" . $_SESSION['user_id'] . ", " . $qid . ", 0);");
}
else
{
    $assoc_dets = mysqli_fetch_assoc($sql_try_dets);
    if($assoc_dets['lastTried'] < (time() + 2))
    {
        sleep(5);
        die("Wait 2 sec between tries.");
    }
    mysqli_query($conne, "UPDATE qn_tries SET wrongTries=wrongTries+1 WHERE q_no=" . $qid . " AND user_id=" . $_SESSION['user_id'] . ";");
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