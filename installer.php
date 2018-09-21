<?php
include "qn_config/conf.php";
include_once 'qn_lib/user_manage.php';
$conne = qnDB_U::start();
$sql_q = "CREATE TABLE `qn_groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_email` text NOT NULL,
  `group_name` text NOT NULL,
  `group_pass` longtext NOT NULL,
  `dateSince` date DEFAULT NULL,
  `noOfUsers` int(11) NOT NULL,
  PRIMARY KEY (group_id)
);";
$sqlRes1 = mysqli_query($conne, $sql_q);
if(!$sqlRes1)
	exit("Couldn't create groups table" . mysqli_error($conne));
else
	echo "Created Groups table<br>";
$sql_q = "CREATE TABLE `qn_mods` (
  `mod_id` int(11) NOT NULL AUTO_INCREMENT,
  `mod_email` text NOT NULL,
  `mod_pass` longtext NOT NULL,
  PRIMARY KEY (mod_id)
);";
$sqlRes1 = mysqli_query($conne, $sql_q);
if(!$sqlRes1)
	exit("Couldn't create moderators table". mysqli_error($conne));
else
	echo "Created Moderators table<br>";
$sql_q = "CREATE TABLE `qn_ques` (
  `q_id` int(11) NOT NULL AUTO_INCREMENT,
  `Question` text NOT NULL,
  `Hint` longtext NOT NULL,
  `ImgURL` longtext NOT NULL,
  `AudURL` longtext NOT NULL,
  `Answer` longtext NOT NULL,
  `qn_salter` longtext NOT NULL,
  PRIMARY KEY (q_id)
);";
$sqlRes1 = mysqli_query($conne, $sql_q);
if(!$sqlRes1)
	exit("Couldn't create questions table". mysqli_error($conne));
else
	echo "Created Questions table<br>";
$sql_q = "CREATE TABLE `qn_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_email` text NOT NULL,
  `u_name` text NOT NULL,
  `propic` longtext NOT NULL,
  `u_pass` longtext NOT NULL,
  `dateSince` datetime DEFAULT NULL,
  `group_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `currQ` datetime DEFAULT NULL,
  `lastTries` int(11) NOT NULL,
  `currTries` int(11) NOT NULL,
  `qTime` bigint(20) NOT NULL,
  PRIMARY KEY (user_id)
);";
$sqlRes1 = mysqli_query($conne, $sql_q);
if(!$sqlRes1)
	exit("Couldn't create Users table". mysqli_error($conne));
else
	echo "Created Users table<br>";
$sql_q = "CREATE TABLE `qn_tries` (
  `try_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `q_no` int(11) NOT NULL,
  `lastTried` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `wrongTries` int(11) NOT NULL,
  PRIMARY KEY (try_id)
)
;";
$sqlRes1 = mysqli_query($conne, $sql_q);
if(!$sqlRes1)
    exit("Couldn't create Tries table". mysqli_error($conne));
else
    echo "Created Tries table<br>";
$sql_q = "INSERT INTO qn_mods (mod_email, mod_pass) VALUES ('".$admin_user."', '".md5($admin_pass)."');";
$sqlRes1 = mysqli_query($conne, $sql_q);
if(!$sqlRes1)
	exit("Couldn't create Moderator account". mysqli_error($conne));
else
	echo "Created moderator account<br>User id = " . $admin_user . " <br>Password = " . $admin_pass;