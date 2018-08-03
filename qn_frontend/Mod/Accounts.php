<?php
if(!isset($_SESSION)){
session_start();}
if((!isset($_SESSION['type']))||$_SESSION['type']!="mod"){
echo "You are not authorised to view this page";
}
else
{
?>
<form action="<?php echo $GLOBALS['host'] . '/backend.php?file=Mod/CreateGroup' ; ?>" method="post" >
	<input type="text" name="name" value="Full Name">
	<input type="text" name="email" value="Email">
	<input type="password" name="pass">
	<input type="submit">
</form>
<?php } ?>