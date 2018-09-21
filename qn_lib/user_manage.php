<?php
class qnDB_U
{
	public static $conn = 0;
	public static function start()
	{
		if(!isset($GLOBALS['dBLogin']))
			die("Database variables not available");
		$conn = new mysqli($GLOBALS['dBLogin']['host'], $GLOBALS['dBLogin']['user'], $GLOBALS['dBLogin']['pass'], $GLOBALS['dBLogin']['dbname']);
		if(! $conn)
			die("Could not connect to database: " . mysqli_error($conn));
		self::$conn = $conn;
		return $conn;
	}
	public static function Login($username, $password, $conn)
	{
		if(!isset($conn))
			die("Database connection not established");
		if (filter_var($username, FILTER_VALIDATE_EMAIL) === false)
			return 0;
		//Try logging in as a user first
        $pass_hash = md5($password);
		$sql = 'SELECT * FROM qn_users WHERE u_email=? and u_pass=? ;';
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ss", $username, md5($password));
		$stmt->execute();
		$result = $stmt->get_result();
		if(mysqli_num_rows($result) == 1)
		{
			$reslt = mysqli_fetch_assoc($result);
			session_start();
			$_SESSION['type'] = "user";
			$_SESSION['email'] = $username;
			$_SESSION['name'] = $reslt['u_name'];
			$_SESSION['score'] = $reslt['score'];
            $_SESSION['user_id'] = $reslt['user_id'];
			$_SESSION['group_id'] = $reslt['group_id'];
			return 1;
		}
		$stmt->close();

		//Now try to log in as group
		$sql = 'SELECT * FROM qn_groups WHERE group_email=? and group_pass=? ;';
		$stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, md5($password));
        $stmt->execute();
        $result = $stmt->get_result();
        if(mysqli_num_rows($result) == 1)
        {
            $reslt = mysqli_fetch_assoc($result);
            session_start();
            $_SESSION['type'] = "group";
            $_SESSION['email'] = $username;
            $_SESSION['name'] = $reslt['group_name'];
            $_SESSION['noOfUsers'] = $reslt['noOfUsers'];
            $_SESSION['group_id'] = $reslt['group_id'];
            return 1;
        }
        $stmt->close();

		return 0;
	}
	public static function stop()
	{
		mysqli_close(self::$conn);
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

        $sql = 'SELECT * FROM qn_users WHERE u_email=? ;';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $match = array();
        $match[0] = $result;
        $stmt->close();

        $sql = 'SELECT * FROM qn_groups WHERE group_email=? ;';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $match[1] = $result;
        $stmt->close();

		if(mysqli_num_rows($match[0]) > 0 || mysqli_num_rows($match[1]) > 0)
			return "Already Exists";
		if(!isset($_SESSION['group_id']))
			return "Not logged in as group";
        $sql = 'INSERT INTO qn_users (u_name,propic,u_email,u_pass,score,dateSince,currQ,group_id) VALUES (?, "/qn_assets/blank.png", ?,?,0,NOW(),NOW(),?)';

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $email, md5($password), $_SESSION['group_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

		$sqlval = $result;

		if(!$sqlval)
			return '802 - Please report to info@comfest.in';
		$sql = "UPDATE qn_groups SET noOfUsers=" . ($_SESSION['noOfUsers'] + 1) . " WHERE group_email='" . $_SESSION['email'] . "' ;";
		$sqlval = mysqli_query($conn, $sql);
		$_SESSION['noOfUsers'] = $_SESSION['noOfUsers'] + 1;
		return 0;
	}
}