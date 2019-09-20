<?php

session_start();
require('dbconnect.php');
require('function.php');

if (!isset($_SESSION['LearnSNS']['id'])) {
    header('Location:signin.php');
}

$comment = $_POST['write_comment'];
$user_id = $_SESSION['LearnSNS']['id'];
$feed_id = $_POST['feed_id'];
insertComments($dbh, $comment, $user_id, $feed_id);
header('Location:timeline.php');
