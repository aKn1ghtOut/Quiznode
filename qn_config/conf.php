<?php

/*
				Website configuration
		Please edit these before installation
		Read the instructions for more details on how to set up.
*/

// The full url on which the domain will be hosted
// ex - "http://mydotcom.com/quiz/"
$GLOBALS['host'] = "http://quiznode/";

// If you are installing the script in sub folder like comfest2/folder
// where "folder" is the name of the folder, add that below
// Otherwise, let it be empty
// ex: $sub = "folder" ;
$sub = "";

// Please don't edit this if it works after installation. If it doesn't contact me at anantbhasin@ymail.com
$GLOBALS['host'] = $GLOBALS['host'] . ($sub != '' ? ('/' . $sub . "/") : '') ;

// The server path to the installation folder of the script
/*
	In most cases, a string concated with $_SERVER['DOCUMENT_ROOT'] should be the solution.
	However, you may need to try multiple values to reach the right one.
	Note: Do not hard-code the path in the other files, please keep your edits confined in this file and in the Themes folder
	And in the frontend folder
*/
$GLOBALS['root'] = $_SERVER['DOCUMENT_ROOT'];

//Do not edit the following line
$GLOBALS['root'] = $GLOBALS['root'] . ($sub != '' ? ('/' . $sub) : '');

$GLOBALS['dBLogin'] = array(

				// If the database is hosted on a server different than localhost: 3036, add the host in the next line
				'host' => "localhost",

				// This is the username of the database user
				'user' => 'root',

				// This is the password of the database server for the user provided above
				'pass' => '',

				//This is the name of the database to be used. The user should have write permissions to this database
				'dbname' => 'quiznode_test',

				);
$GLOBALS['pages'] = array('none', 'Home', 'Account', 'Play', 'Group', 'Login', 'Leaderboard', 'Mod', '404');

$GLOBALS['title'] = "Quiznode";

$admin_user = "youremail@email.com";
$admin_pass = "YourPass";

//The Theme QuizNode would be using. Please do not change this unless you know what you are doing.
$currTheme = "Theme02";
