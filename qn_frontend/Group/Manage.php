<?php
if(!isset($_SESSION))
session_start();
if((!isset($_SESSION['type']))||$_SESSION['type']!="group")
echo "You are not authorised to view this page";
else
{
?>
<style type="text/css">
	#form
	{
		position: absolute;
		left: 50%;
		transform: translateX(-50%);
		max-height: calc(100vh - 130px);
		overflow-y: auto;
		text-align: center;
	}
	#form input, label
	{display: inline-block; margin-top: 20px; font-size: 21px;}
	#form label{font-size: 24px;}
	#form input{border-radius: 15px; padding: 5px 10px; outline: none; border:2px solid black;}
</style>
<div id="form">
<span style="font-size: 25px; font-weight: bold;">Add User</span>
<form action="<?php echo $GLOBALS['host'] . 'backend.php?file=Account/CreateUser' ; ?>" method="post"  style="text-align: right;">
	<label for="name">Full Name: </label><input type="text" name="name" placeholder="Full Name"><br>
	<label for="email">Email Address: </label><input type="text" name="email" placeholder="Email"><br>
	<label for="pass">Password: </label><input type="password" name="pass"><br>
	<label for="pass">Confirm Password: </label><input type="password" name="pass1"><br>
	<input type="submit" value="Add User">
</form>
</div>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
	$('body').append('<div id="ResultBlock" style="position: fixed; right: 5px; bottom: 5px; height: 30px; padding: 5px; background-color: rgb(20, 150, 50); display: none; width: 200px; text-align: center; color: white;">Success</div>');
	$('form').submit(function(event) {
					subBut = 	$(this).find('input[name=submit]');
					subBut.attr('disabled', 'true');
					if($('input[name=pass]').val() != $('input[name=pass1]').val())
					{
	            		$('#ResultBlock').css('background-color', "rgb(150,20,50)").html("Passwords don't match").show(500).delay(1000).hide(500);
	            		event.preventDefault();
	            		$(this).find('input[name=submit]').removeAttr('disabled');
	            		return;
					}
			        // get the form data
			        // there are many ways to get this data using jQuery (you can use the class or id also)
			        var formData = {
			        	'name'              : $('input[name=name]').val(),
			            'email'              : $('input[name=email]').val(),
			            'pass'              : $('input[name=pass]').val(),
			        };

			        // process the form
			        $.ajax({
			            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
			            url         : '<?php echo $GLOBALS['host'] ; ?>/backend.php?file=Account/CreateUser', // the url where we want to POST
			            data        : formData, // our data object
			            datatype	: "html",
			            success		: function(data)
			            {
			            	if (data=="created") 
			            	{
			            		$('#ResultBlock').css('background-color', "rgb(20,150,50)").html("User Created").show(500).hide(1000);
			            		subBut.removeAttr('disabled');
			            	}
			            	else
			            	{
			            		$('#ResultBlock').css('background-color', "rgb(150,20,50)").html(data).show(500).delay(1000).hide(1000);
			            		subBut.removeAttr('disabled');
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
<?php } ?>