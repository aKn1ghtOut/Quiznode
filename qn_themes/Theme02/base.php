<?php
if (!isset($_SESSION)) {
	session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($pageTitle)) echo $pageTitle.' - '; ?><?php echo $GLOBALS['title'];?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['host'];?>/Themes/Theme02/styles/base.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['host'];?>/Themes/Theme02/styles/style.css">
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">

</head>
<body class="" style="font-family: 'Josefin Sans', sans-serif; max-width: 100vw; max-height: 100vh; background-color: #fafafa; overflow-x: hidden; overflow-y: auto;">
	<style type="text/css">
	#Logo, #topbar, #menu, #menu>div>div
	{position: absolute; display: block;}
	#topbar
	{width: 100vw; left: 0;}
	#topbar
	{top: 0;left: 0; height: 120px; background-color: #0477BE;/*#eae3ea;*/ width: 100%;}
	#menu
	{top: <?php if(!isset($_SESSION['type'])){ ?>50px<?php } else { ?>40px<?php } ?>; right: 0; position: absolute; color: white; font-size: 25px;}
	#menu a{color: white/*#ff6a5c*/; text-decoration: none;}
	#Logo
	{top: 10px;font-size: 100px; color: white; left: 0; overflow-y: hidden; height: 100px;}
	.ddAcc{height: 0; overflow: hidden; background-color: #013453; transition-duration: 1s; position: relative; top: 100%; width: 125px; left: calc((100% - 125px) / 2); text-align: center; padding-top: 0;}
	.ddAcc .page{padding-top: 0; padding-bottom: 3px;}
	.Account:hover .ddAcc{height: 100px; transition-duration: 1s; padding-top: 5px;}
	.page{padding: 10px;}
	</style>
	<div class="abs pW100" id="content" style="top: 130px; max-width: 1000px; left: 50%; transform: translateX(-50%); -webkit-transform: translateX(-50%); min-height: calc(100vh - 130px); text-align: center;">
		<?php include $path; ?>
	</div>
	<div id="topbar" class="abs pW100"><div class="rel pW100"><div class="abs" style="max-width: 1000px; width: 100vw; left: 50%; transform: translateX(-50%); -webkit-transform: translateX(-50%); height: 120px;">
		<div class="cW100" style="position: relative; height: 100%;">
			<span class="inlBlk" id="Logo"><a href="<?php echo $GLOBALS['host']; ?>" style="text-decoration: none; color: white;"><img src="<?php echo $GLOBALS['host'];?>/Themes/Theme02/assets/quizartfull.png" style="height: 100px; width: auto;"></a></span>
			<div class="inlBlk" id="menu">
				<a class="page" href="<?php echo $GLOBALS['host'];?>/">Home</a>
				<?php if(!isset($_SESSION['type'])||!($_SESSION['type'] == "user")) { ?>
				<a class="page" href="<?php echo $GLOBALS['host'];?>/Leaderboard">Leaderboard</a>
				<?php } ?>
				<?php if (!isset($_SESSION['type'])) { ?>
				<a class="page" href="<?php echo $GLOBALS['host'];?>/Account/Login">Login</a>
				<? } else { ?>
				<?php if($_SESSION['type'] == 'mod') { ?>
				<a class="page" href="<?php echo $GLOBALS['host'];?>/Mod/Questions">Questions</a>
				<?php } if($_SESSION['type'] == "user") { ?>
				<a class="page" href="<?php echo $GLOBALS['host'];?>/Play">Play</a>
				<div class="page rel inlBlk Account"><span style="cursor: pointer;">Leaderboard</span>
					<div class="ddAcc">
					<a class="page blk" href="<?php echo $GLOBALS['host'];?>/Leaderboard">Global</a>
					<a class="page blk" href="<?php echo $GLOBALS['host'];?>/Group/Leaderboard">School</a>
					</div>
				</div>
				<?php } ?>
				<div class="page rel inlBlk Account"><span style="cursor: pointer;">Account</span>
					<div class="ddAcc">
						<a class="page blk" href="<?php echo $GLOBALS['host'];?>/Account/Manage">Manage</a>
						<?php if($_SESSION['type'] == "group") { ?>
						<a class="page blk" href="<?php echo $GLOBALS['host'];?>/Group/Manage">Add Users</a>
						<?php } if($_SESSION['type'] == 'mod') { ?>
						<a class="page blk" href="<?php echo $GLOBALS['host'];?>/Mod/Accounts">Manage Groups</a>
						<?php } ?>
						<a class="page blk" href="<?php echo $GLOBALS['host'] ; ?>backend.php?file=Account/Logout">Logout</a>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div></div></div>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-85373424-1', 'auto');
	  ga('send', 'pageview');

	</script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $GLOBALS['host'];?>/Themes/Theme02/scripts/base.js"></script>
</body>
</html>
