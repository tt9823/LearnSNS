<?php
session_start();
require('dbconnect.php');
require('function.php');

$user_id = $_GET['following_id'];
$signin_user_id = $_SESSION['LearnSNS']['id'];
createFollowers($dbh, $user_id, $signin_user_id);
// var_dump($user_id);
// die();

header("Location: profile.php?user_id=".$user_id);
exit();
