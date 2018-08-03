<?php
class qnDB_U
{
	public static $conn = 0;
	public static function start()
	{
		if(!isset($GLOBALS['dBLogin']))
			die("Database variables not available");
		$conn = mysql_connect($GLOBALS['dBLogin']['host'], $GLOBALS['dBLogin']['user'], $GLOBALS['dBLogin']['pass']);
		if(! $conn)
			die("Could not connect to database: " . mysql_error());
		$selectDB = mysql_select_db($GLOBALS['dBLogin']['dbname']);
		if(! $selectDB)
			die("Could not select database: ". mysql_error());
		return $conn;
	}
	public static function Login($username, $password, $conn)
	{
		if(!isset($conn))
			die("Database connection not established");
		if (filter_var($username, FILTER_VALIDATE_EMAIL) === false)
			return 0;
		//Try logging in as a user first
		$sql = 'SELECT * FROM qn_users WHERE u_email="'. $username .'" and u_pass="'.md5($password).'" ;';
		$sqlval = mysql_query($sql, $conn);
		if(mysql_num_rows($sqlval) == 1)
		{
			$reslt = mysql_fetch_assoc($sqlval, MYSQL_ASSOC);
			session_start();
			$_SESSION['type'] = "user";
			$_SESSION['email'] = $username;
			$_SESSION['name'] = $reslt['u_name'];
			$_SESSION['score'] = $reslt['score'];
			$_SESSION['group_id'] = $reslt['group_id'];
			mysql_free_result($sqlval);
			return 1;
		}
		mysql_free_result($sqlval);

		//Now try to log in as group
		$sql = 'SELECT * FROM qn_groups WHERE group_email="'. $username .'" and group_pass="'.md5($password).'" ;';
		$sqlval = mysql_query($sql, $conn);
		if(mysql_num_rows($sqlval) == 1)
		{
			$reslt = mysql_fetch_assoc($sqlval, MYSQL_ASSOC);
			session_start();
			$_SESSION['type'] = "group";
			$_SESSION['email'] = $username;
			$_SESSION['name'] = $reslt['group_name'];
			$_SESSION['noOfUsers'] = $reslt['noOfUsers'];
			$_SESSION['group_id'] = $reslt['group_id'];
			mysql_free_result($sqlval);
			return 1;
		}
		mysql_free_result($sqlval);
		return 0;
	}
	public static function stop()
	{
		mysql_close();
	}
	public static function logout()
	{
		session_unset();
		session_destroy();
	}
	public static function createUser($name, $email, $password, $conn)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
			return "Not a Valid Email";
		$match = array(mysql_query('SELECT * FROM qn_users WHERE u_email="'. $email .'" ;', $conn), mysql_query('SELECT * FROM qn_groups WHERE group_email="'. $email .'" ;', $conn));
		if(mysql_num_rows($match[0]) > 0 || mysql_num_rows($match[1]) > 0)
			return "Already Exists";
		if(!isset($_SESSION['group_id']))
			return "Not logges in as group";
		$sql = 'INSERT INTO qn_users (u_name,propic,u_email,u_pass,score,dateSince,currQ,group_id) VALUES ("'. $name .'", "/qn_assets/blank.png", "'. $email .'","' . md5($password) . '",0,NOW(),NOW(),'. $_SESSION['group_id'] .')';
		$sqlval = mysql_query($sql, $conn);
		if(! $sqlval)
			return '802 - Please report to anantbhasin@ymail.com';
		$sql = "UPDATE qn_groups SET noOfUsers=" . ($_SESSION['noOfUsers'] + 1) . " WHERE group_email='" . $_SESSION['email'] . "' ;";
		$sqlval = mysql_query($sql, $conn);
		$_SESSION['noOfUsers'] = $_SESSION['noOfUsers'] + 1;
		return 0;
	}
}