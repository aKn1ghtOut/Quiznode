<?php
class qnDB_M
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

		//Now try to log in as mod
		$sql = 'SELECT * FROM qn_mods WHERE mod_email="'. $username .'" and mod_pass="'.md5($password).'" ;';
		$sqlval = mysql_query($sql, $conn);
		if(mysql_num_rows($sqlval) == 1)
		{
			session_start();
			$_SESSION['type'] = "mod";
			$_SESSION['email'] = $username;
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
	public static function createGroup($name, $email, $password, $conn)
	{
		$match = array(mysql_query('SELECT * FROM qn_users WHERE u_email="'. $email .'" ;', $conn), mysql_query('SELECT * FROM qn_groups WHERE group_email="'. $email .'" ;', $conn));
		if(mysql_num_rows($match[0]) > 0 || mysql_num_rows($match[1]) > 0)
			return "error_801: Email already in use";
		$sql = 'INSERT INTO qn_groups (group_name, group_email, group_pass, noOfUsers, dateSince) VALUES ("'.$name.'", "'.$email.'", "'. md5($password) . '", 0, NOW() ) ;';
		$sqlval = mysql_query($sql, $conn);
		if(! $sqlval)
			return 'error_802: ' . mysql_error();
		return 1;
	}
}