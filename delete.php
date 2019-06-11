<?php
session_start();
require('dbconnect.php');
require('function.php');
$feed_id = $_GET['feed_id'];
deletePost($dbh, $feed_id);
header("Location: timeline.php");
exit();
