<?php 
	session_start();
	include 'qn_config/conf.php';
	$linkPre = explode("/", $sub);
	$path = $_SERVER['REQUEST_URI'];
	$path1 = explode("?", $path);
	$path = ltrim($path1[0], '/');    // Trim leading slash(es)
	$elem = explode('/', $path);
	if(count($linkPre) > 0)
	{
		for ($i=count($linkPre); $i > 0 ; $i--) { 
			if($sub == "")
				break;
			array_shift($elem);
		}
	}
	$path = join("/", $elem);
	//$elements = explode('/', $path);                // Split path on slashes
	if(strlen($path) == 0) {                       // No path elements means home
	    $path = $GLOBALS['root'] . '/' . 'qn_frontend/Home.php';
	}
	else
		$path = $GLOBALS['root'] . '/' . 'qn_frontend/' . $path . '.php';
	$pageTitle = end($elem)!=""?end($elem):"Home";
	if (!file_exists($path)) {
		header("Location: " . $GLOBALS['host'] . '/404');
	}
	include 'qn_themes/'. $currTheme.'/base.php' ;
?>