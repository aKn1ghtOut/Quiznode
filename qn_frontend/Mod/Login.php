<?php 
if(!isset($_SESSION))
	session_start();
if (!isset($_SESSION['type'])) { ?>
<style type="text/css">
	form input
	{
		border: 1px solid black;
		border-radius: 3px;
		outline: none;
	}
</style>
<div style="position: absolute;display: block; left: 50%; transform: translateX(-50%);">
<form action="<?php echo $GLOBALS['host']; ?>/backend.php?file=/Mod/Login" method="post" style="position: relative;">
	<input type="text" name="user" value="Email"><br>
	<input type="password" name="pass" ><br>
	<input type="submit" name="submit">
</form>
</div>
<?php } else { ?>
You are already logged in.
<?php } ?>