<?php
include $GLOBALS['root'] . "/qn_lib/user_manage.php";
$conne = qnDB_U::start();
$sql = "SELECT * FROM qn_users ORDER BY score DESC, qTime ASC, currQ ASC ;";
$sqlRun = mysqli_query($conne, $sql);
if(!$sqlRun)
die("Service Unavailable");
$ij = 0;
?>
<style type="text/css">
	table td, table tr
	{
		padding: 5px;
		color: white;
		text-align: center;
	}
	td{padding: 10px 10px; font-size: 28px; }
	tr:nth-child(even){background-color: #0477BE;}
	tr:nth-child(odd){background-color: #1A237E;}
</style>
<table style="max-width: 100%; display: inline-block;">
<tr style="font-weight: bold;"><td>Rank</td><td>Full Name</td><td>Profile Picture</td><td>School</td><td>Level</td><td>Participation in CF</td></tr>
	<?php while($array = mysqli_fetch_assoc($sqlRun)) {
		$sql2run = "SELECT group_name FROM qn_groups WHERE group_id=".$array['group_id'] . " ;";
		$sqlrunn = mysqli_query($conne, $sql2run);
		$group_name_found = mysqli_fetch_assoc($sqlrunn);
		?>
		<tr><td><?php $ij++; echo $ij; ?></td><td><?php echo $array['u_name'] ; ?></td><td><img src="<?php echo $array['propic'] ; ?>" width="50px" height="50px" /></td><td><?php echo $group_name_found['group_name'] ; ?></td><td><?php echo $array['score'] ; ?></td><td><?php echo $group_name_found['group_name']=="SAJS"?"Not Participating":"Participating" ; ?></td></tr>
		<?php
	}?>
</table>
<?php qnDB_U::stop(); ?>