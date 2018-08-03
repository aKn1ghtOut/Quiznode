<?php
if(!isset($_SESSION))
session_start();
if(!isset($_SESSION['type']))
die("Please login to continue");
?>
<style type="text/css">
	form input
	{
		margin: 20px;
		font-size: 21px;
		outline: none;
		border: 2px solid black;
		border-radius: 20px;
		padding: 5px 10px;
	}
	.frags
	{
		display: inline-block;
		margin: 20px;
		background-color: white;
		padding: 20px;
		border-radius: 5px;
	}
</style>
<div style="text-align: center; font-weight: " class="frags" id="passw" >
<span style="display: block; font-size: 30px;">Change Password</span>
<form action="<?php echo $GLOBALS['host'] ; ?>backend.php?file=Account/ChangePassword" method="post" style="display: inline-block; text-align: right; font-size: 24px;">
	<label for="pass1">Enter current password:</label><input type="Password" name="pass1"><br>
	<label for="pass2">Enter new password:</label><input type="Password" name="pass2"><br>
	<label for="pass3">Enter new password:</label><input type="Password" name="pass3"><br>
	<input type="submit" name="submit" value="Change">
</form>
</div>
<div class="frags" id="picChange">
<span style="display: block; font-size: 30px; font-weight: bold;">Change Profile Picture</span>
<span style="display: block; font-size: 20px;">(Square pictures preferred. Only JPG, JPEG and PNG formats)</span>
	<form action="<?php echo $GLOBALS['host'] ; ?>backend.php?file=Account/uploadPic" method="post" enctype= "multipart/form-data">
		<label for="propic">Upload Picture: </label> <input id="propic" type="file" name="propic"><br><br>
		<input type="submit" name="submit">
	</form>
</div>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
	$('body').append('<div id="ResultBlock" style="position: fixed; right: 5px; bottom: 5px; height: 30px; padding: 5px; background-color: rgb(20, 150, 50); display: none; width: 200px; text-align: center; color: white;">Success</div>');
	$('#passw form').submit(function(event) {
					subBut = 	$(this).find('input[name=submit]');
					subBut.attr('disabled', 'true');
					if($('input[name=pass2]').val() != $('input[name=pass3]').val())
					{
	            		$('#ResultBlock').css('background-color', "rgb(150,20,50)").html("New Passwords don't match").show(500).delay(1000).hide(500);
	            		event.preventDefault();
	            		$(this).find('input[name=submit]').removeAttr('disabled');
	            		return;
					}
			        // get the form data
			        // there are many ways to get this data using jQuery (you can use the class or id also)
			        var formData = {
			            'pass1'              : $('input[name=pass1]').val(),
			            'pass2'              : $('input[name=pass2]').val()
			        };

			        // process the form
			        $.ajax({
			            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
			            url         : '<?php echo $GLOBALS['host'] ; ?>/backend.php?file=Account/ChangePassword', // the url where we want to POST
			            data        : formData, // our data object
			            datatype	: "html",
			            success		: function(data)
			            {
			            	if (data=="Changed") 
			            	{
			            		$('#ResultBlock').css('background-color', "rgb(20,150,50)").html("Password Changed").show(500).hide(1000);
			            	}
			            	else
			            	{
			            		$('#ResultBlock').css('background-color', "rgb(150,20,50)").html(data).show(500).delay(1000).hide(1000);
			            	}
	            		$(this).find('input[name=submit]').removeAttr('disabled');
			            },
			            error: function (error) {
             			     subBut.removeAttr('disabled');
             			     $('#ResultBlock').css('background-color', "rgb(150,20,50)").html("Error").show(500).delay(1000).hide(500);
             			 }
			        });
			        // stop the form from submitting the normal way and refreshing the page
			        event.preventDefault();
			    });
	$('#picChange form').submit(function(event) {
					subBut = 	$(this).find('input[name=submit]');
			        // process the form
			        $.ajax({
			            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
			            url         : '<?php echo $GLOBALS['host'] ; ?>/backend.php?file=Account/uploadPic', // the url where we want to POST
			            data        : new FormData(this), // our data object
			            cache: false,
              			contentType: false,
          		   	   	processData: false,
			            datatype	: "html",
			            success		: function(data)
			            {
			            	if (data=="Success") 
			            	{
			            		$('#ResultBlock').css('background-color', "rgb(20,150,50)").html("Profile Picture changed").show(500).hide(1000);
			            	}
			            	else
			            	{
			            		$('#ResultBlock').css('background-color', "rgb(150,20,50)").html(data).show(500).delay(1000).hide(1000);
			            	}
	            		$(this).find('input[name=submit]').removeAttr('disabled');
			            },
			            error: function (error) {
             			     subBut.removeAttr('disabled');
             			     $('#ResultBlock').css('background-color', "rgb(150,20,50)").html("Error").show(500).delay(1000).hide(500);
             			 }
			        });
			        // stop the form from submitting the normal way and refreshing the page
			        event.preventDefault();
			    });
</script>