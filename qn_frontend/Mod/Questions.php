<?php
if (!isset($_SESSION)) {
session_start();
}
else
{
	if ((!isset($_SESSION['type']))||$_SESSION['type']!="mod") {
		?>
		You are not authorised to view this page.
		<?php
	}
	else
	{
		?>
		<form action="<?php echo $GLOBALS['host'] ; ?>/backend.php?file=Mod/CreateQuestion" enctype="multipart/form-data" method="post">
			<label for="Question">Question : </label><input type="text" name="Question"><br>
			This would be the title<br><br>
			<label for="Answer">Answer : </label><input type="text" name="Answer"><br>
			Note that this would exactly be the answer and will be case-sensitive<br><br>
			<label for="Hint">Hint(or link to video) : </label><input type="text" name="Hint"><br>
			Leave this empty if it isn't needed<br><br>
			<label for="Image">Image : </label><input type="file" name="Image" ><br>
			JPEG(also JPG) and PNG formats are preferred above all others.<br>
			<label for="Audio">Audio : </label><input type="file" name="Audio" ><br>
			Please upload only mp3 files<br><br>
			<input type="submit" name="submit">
		</form>
		<?php
	}
}
?>