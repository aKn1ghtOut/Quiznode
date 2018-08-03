<?php
$GLOBALS['postvar'] = $_POST;
include 'qn_config/conf.php';
if(isset($_GET['file']))
	include 'qn_backend/'.$_GET['file'].'.php';
?>