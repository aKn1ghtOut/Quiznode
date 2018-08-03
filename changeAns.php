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
if ((!isset($_SESSION['type']))||$_SESSION['type']!="mod") { 
	$_SESSION = array();
	?>
<style type="text/css">
	form input
	{
		border: 1px solid black;
		border-radius: 3px;
		outline: none;
	}
</style>
<div style="position: absolute;display: block; left: 50%; transform: translateX(-50%);">
<form action="<?php echo $GLOBALS['host'] ; ?>backend.php?file=/Mod/Login" method="post" style="position: relative;">
	<input type="text" name="user" value="Email"><br>
	<input type="password" name="pass" ><br>
	<input type="submit" name="submit">
</form>
</div>
<?php } else { ?>
<?php 
	if(!isset($_POST['qno'])) 
	{ 
?>
<form method="post" action="/changePass.php">
	<input type="text" name="qno" placeholder="Q No"/>
	<input type="text" name="Ans" placeholder="Answer"/>
	<input type="submit" name="submit" />
</form>
<?php 
} 
else
{
	include_once "qn_config/conf.php";
	include_once 'qn_lib/mod_manage.php';
	if(!isset($_POST['qno'])||!isset($_POST['Ans']))
		exit("error in submission");
	$conne = qnDB_M::start();
	$resultFn = setSalt($_POST['Ans']);
	$sql = 'UPDATE qn_ques SET Answer="'.$resultFn['password'].'", qn_salter="'.$resultFn['salt'].'" WHERE q_id='.$_POST['qno'] . ';';
	echo $sql;
	$query = mysql_query($sql, $conne);
	qnDB_M::stop();
	if(!$query)
		exit("Query failed" . mysql_error());
	else
		exit("Query passed");
} } ?>