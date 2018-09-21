<?php
if(!isset($_SESSION))
	session_start();
if((!isset($_SESSION['type']))||$_SESSION['type'] != "user")
	echo("Not Logged In");
else
{
	include_once $GLOBALS['root'] . "/qn_lib/user_manage.php";
	$conne = qnDB_U::start();
	$qid = $_SESSION['score'] + 1;
	$qSet = false;
	if(isset($_GET['q'])&&$_GET['q']<$qid)
	{
		$qid = $_GET['q'];
		$qSet = true;
	}
	$sql = "SELECT * FROM qn_ques WHERE q_id=" . $qid . " ;";
	$sqlRes = mysqli_query($conne, $sql);
	if(mysqli_num_rows($sqlRes) == 0){
		?><span style="font-size: 30px;">You have reached end of Quiz. Nice Quizzing!<br>Check back later for further questions.</span><?php
	}
	else
	{
		$obj = mysqli_fetch_assoc($sqlRes);
	?>
		<select id="pageID" style="">
			<option value="<?php echo ($_SESSION['score'] + 1) ; ?>" <?php if(!$qSet){ ?>selected<?php } ?>>Current Question</option>
			<?php for ($i=1; $i < ($_SESSION['score'] + 1); $i++) { ?>
			<option value="<?php echo $i ; ?>" <?php if($qid==$i) { ?>selected<?php }  ?>>Question <?php echo $i; ?></option>
		<?php } ?>
		</select>
<br><span style="font-size: 30px; font-weight: bold;"><br>For hints, stay tuned with the official Facebook page.</span><br>
		<div style="width: 500px; max-width: 100%; position: absolute; top: 50%;left: 50%; max-height: 100%; overflow-y: auto; overflow-x: hidden; transform: translateX(-50%) translateY(calc(-50% + 100px)); -webkit-transform: translateX(-50%) translateY(calc(-50% + 100px)); background-color: white; min-height: 500px;">
			<div style="position: relative; width: 100%; height: calc(100% - 200px); padding: 150px 0 50px 0;">
			<div style="position: absolute; top: 5px; left: 50%; transform: translateX(-50%); -webkit-transform: translateX(-50%);">
				<span style="font-size: 30px;"><?php echo $obj['Question'] ?></span><br>
				<?php if($obj['Hint'] != "") { ?><span style="font-size: 24px;"><?php echo $obj['Hint'] ; ?></span><br><?php } ?></div>
				<?php if($obj['ImgURL'] != "") { ?><img style="max-width: 100%; max-height: 100%; width: auto;" src="<?php echo $obj['ImgURL'] ; ?>"><br><?php } ?>
				<?php if($obj['AudURL'] != "") { ?><audio controls>
												  <source src="<?php echo $obj['AudURL'] ; ?>" type="audio/mpeg">
												Your browser does not support the audio element.
												</audio><br>
				<?php } ?>
				<?php if(!$qSet) { ?><form action="<?php echo $GLOBALS['host'] ; ?>backend.php?file=CheckAnswer" method="post" style="position: absolute;bottom: 5px; width: 100%; text-align: center;">
					<input type="text" name="Answer" style="outline: none;border: 2px solid black; border-radius: 10px; font-size: 15px; padding: 2px 4px; display: inline-block;">  
					<input type="submit" name="submit" value="Submit" style="outline: none;border: 2px solid black; border-radius: 10px; font-size: 15px; padding: 3px 3px; display: inline-block;">
				</form><?php } ?>
			</div>
		</div>
		<!--<div id="ResultBlock" style="position: fixed; left: calc(50vw - 100px); top: 0; height: 30px; padding: 5px; background-color: rgb(20, 150, 50); display: none; width: 200px; text-align: center;">Success</div>-->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function()
			{
				$('body').append('<div id="ResultBlock" style="position: fixed; right: 5px; bottom: 5px; height: 30px; padding: 5px; background-color: rgb(20, 150, 50); display: none; width: 200px; text-align: center; color: white;">Success</div>');
				$('form').submit(function(event) {

					subBut = 	$(this).find('input[name=submit]');
					subBut.attr('disabled', 'true');

			        // get the form data
			        // there are many ways to get this data using jQuery (you can use the class or id also)
			        var formData = {
			            'Answer'              : $('input[name=Answer]').val()
			        };

			        // process the form
			        $.ajax({
			            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
			            url         : '<?php echo $GLOBALS['host'] ; ?>/backend.php?file=CheckAnswer', // the url where we want to POST
			            data        : formData, // our data object
			            datatype	: "html",
			            success		: function(data)
			            {
			            	if (data=="Correct") 
			            	{
			            		$('#ResultBlock').css('background-color', "rgb(20,150,50)").html("Success").show(500);
			            		setTimeout(function(){
			            		location.reload();}, 1000);
			            	}
			            	else
			            	{
			            		$('#ResultBlock').css('background-color', "rgb(150,20,50)").html(data).show(500).delay(1000).hide(500);
			            	}
			            	subBut.removeAttr('disabled');
			            },
			            error: function (error) {
             			     subBut.removeAttr('disabled');
             			     $('#ResultBlock').css('background-color', "rgb(150,20,50)").html("Error").show(500).delay(1000).hide(500);
             			 }
			        });
			        // stop the form from submitting the normal way and refreshing the page
			        event.preventDefault();
			    });
			    $('#pageID').change(function()
			    	{
			    		window.location.href = "<?php echo $GLOBALS['host'] ; ?>/Play?q=" + $(this).val();
			    	});
			});
	</script>
	<?php
}
qnDB_U::stop();
}
?>