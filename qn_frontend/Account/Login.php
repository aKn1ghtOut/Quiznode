
<?php 
if(!isset($_SESSION))
	session_start();
if (!isset($_SESSION['type'])) { ?>
<style type="text/css">
	form input
	{
		border: 2px solid black;
		border-radius: 15px;
		outline: none;
		font-size: 21px;
		margin: 10px 0;
		padding: 5px 10px;
	}
	form
	{
	font-size: 30px;
	}
</style>
<div style="position: absolute;display: block; left: 50%; transform: translateX(-50%); -webkit-transform: translateX(-50%); font-size: 30px; top: 100px;">
<span style="display: block; text-align:center; font-size: 45px; margin-bottom: 30px;">Login</span>
<form action="<?php echo $GLOBALS['host']; ?>backend.php?file=/Account/Login" method="post" style="position: relative;">
<div style="display:block; text-align: right;">
	<label for="pass">Email:  </span><input type="text" name="user" placeholder="email@abc.xyz"><br>
	<label for="pass">Password:  </span><input type="password" name="pass" ><br>
	<input type="submit" name="submit" value="Login">
</div>
</form>
</div>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
	$('body').append('<div id="ResultBlock" style="position: fixed; right: 5px; bottom: 5px; height: 30px; padding: 5px; background-color: rgb(20, 150, 50); display: none; width: 200px; text-align: center; color: white;">Success</div>');
	$('form').submit(function(event) {
					subBut = 	$(this).find('input[name=submit]');
					subBut.attr('disabled', 'true');

			        var formData = {
			            'user'              : $('input[name=user]').val(),
			            'pass'              : $('input[name=pass]').val(),
			        };

			        $.ajax({
			            type        : 'POST',
			            url         : '<?php echo $GLOBALS['host'] ; ?>/backend.php?file=/Account/Login',
			            data        : formData,
			            datatype	: "html",
			            success		: function(data)
			            {
			            	if (data=="Logged In") 
			            	{
			            		$('#ResultBlock').css('background-color', "rgb(20,150,50)").html("Logged in").show(100);
			            		setTimeout(function(){
			            		window.location.href = "<?php echo $GLOBALS['host'] ; ?>";}, 500);
			            	}
			            	else
			            	{
			            		$('#ResultBlock').css('background-color', "rgb(150,20,50)").html(data).show(500).delay(1000).hide(1000);
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
</script>
<?php } else { ?>
You are already logged in.
<?php } ?>