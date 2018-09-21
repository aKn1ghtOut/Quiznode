<?php
class qnDB_M
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
        $sql = 'SELECT * FROM qn_mods WHERE mod_email=? and mod_pass=? ;';
        $stmt = self::$conn->prepare($sql);
        $stmt->bind_param("ss", $username, md5($password));
        $stmt->execute();
        $result = $stmt->get_result();
        if(mysqli_num_rows($result) == 1)
        {
            $reslt = mysqli_fetch_assoc($result);
            session_start();
            $_SESSION['type'] = "mod";
            $_SESSION['email'] = $username;
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
	public static function createGroup($name, $email, $password, $conn)
	{
		$match = array(mysqli_query($conn, 'SELECT * FROM qn_users WHERE u_email="'. $email .'" ;'), mysqli_query($conn, 'SELECT * FROM qn_groups WHERE group_email="'. $email .'" ;'));
		if(mysqli_num_rows($match[0]) > 0 || mysqli_num_rows($match[1]) > 0)
			return "error_801: Email already in use";
		$mdPass = md5($password);
		$sql = 'INSERT INTO qn_groups (group_name, group_email, group_pass, noOfUsers, dateSince) VALUES ("'.$name.'", "' . $email . '", "'. $mdPass . '", 0, NOW() ) ;';
		$sqlval = mysqli_query($conn, $sql);
		if(! $sqlval)
			return 'error_802: ' . mysqli_error($conn);
		return 1;
	}
}