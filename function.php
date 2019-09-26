<?php

function createUser($dbh, $name, $email, $password, $img_name)
{
    $sql = "INSERT INTO `users` SET `name` = ?, `email` = ?, `password` = ?, `img_name` = ?, `created` = NOW()";
    $data = array($name, $email, password_hash($password, PASSWORD_DEFAULT), $img_name, );
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
}

function selectUser($dbh, $email)
{
    $sql = "SELECT * from `users` WHERE `email` = ?";
    $data = array($email);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    return $record;
}

function getSinginUser($dbh, $user_id)
{
    $sql = "SELECT * from `users` WHERE `id` = ?";
    $data = array($user_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $signin_user;
}

function createFeed($dbh, $feed, $user_id, $img_name)
{
    $sql = 'INSERT INTO `feeds` SET `feed` = ?, `user_id` = ?, `img_name` = ?, created = NOW()';
    $data = array($feed, $user_id, $img_name);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
}

function getAllFeeds($dbh, $content_per_page, $start)
{
    $sql = "SELECT `f`.*, `u`.`name`, `u`.`img_name` FROM `feeds` AS `f` LEFT JOIN `users` AS `u` ON `f`.`user_id` = `u`.`id` ORDER BY id DESC LIMIT $content_per_page OFFSET $start";
    $data = array();
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $feeds = $stmt->fetchall(PDO::FETCH_ASSOC);
    return $feeds;
}

function deletePost($dbh, $feed_id)
{
    $sql = "DELETE FROM `feeds` WHERE `id` = ?";
    $data = array($feed_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
}

function editGetFeed($dbh, $feed_id)
{
    $sql = "SELECT `f`.*, `u`.`name`, `u`.`img_name` FROM `feeds` AS `f` LEFT JOIN `users` AS `u` ON `f`.`user_id` = `u`.`id` WHERE `f`.`id` = ?";
    $data = array($feed_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $feeds = $stmt->fetch(PDO::FETCH_ASSOC);
    return $feeds;
}

function upDatePost($dbh, $feed_content, $feed_id)
{
    $sql = 'UPDATE `feeds` SET `feed` = ? WHERE `id` = ?';
    $data = array($feed_content, $feed_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
}

function feedsCnt($dbh)
{
    $sql = "SELECT COUNT(*) AS `cnt` FROM `feeds`";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $record_cnt = $stmt->fetch(PDO::FETCH_ASSOC);
    return $record_cnt;
}


function getAllusers($dbh)
{
    $sql = "SELECT * FROM `users`";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchall(PDO::FETCH_ASSOC);
    return $users;
}

function getUsersFeedCnt($dbh, $user)
{
    $record_id = $user['id'];
    $sql = 'SELECT COUNT(*) AS `cnt` FROM `feeds` WHERE `user_id` = ?';
    $data = array($record_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $feed_cnt = $stmt->fetch(PDO::FETCH_ASSOC);
    return $feed_cnt;
}

function insertComments($dbh, $comment, $user_id, $feed_id)
{
    $sql = $sql = 'INSERT INTO `comments` SET `comment` = ?, `user_id` = ?, `feed_id` = ?, `created` = NOW()';
    $data = array($comment, $user_id, $feed_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
}

function getComment($dbh, $feed)
{
    $feed_id = $feed['id'];
    $sql = "SELECT * FROM `comments` LEFT JOIN `users` ON `comments`.`user_id` = `users`.`id` WHERE `comments`.`feed_id` = ?";
    $data = array($feed_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);
    return $comment;
}

function getCommentcnt($dbh, $feed)
{
    $feed_id = $feed['id'];
    $sql = 'SELECT COUNT(*) AS `cnt` FROM `comments` WHERE `feed_id` = ?';
    $data = array($feed_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $comment_cnt = $stmt->fetch(PDO::FETCH_ASSOC);
    return $comment_cnt;
}

function getTargetUser($dbh, $user_id)
{
    $sql = "SELECT * from `users` WHERE `id` = ?";
    $data = array($user_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function createFollowers($dbh, $user_id, $signin_user_id)
{
    $sql = 'INSERT INTO `followers` SET `user_id` = ?, `follower_id` = ?';
    $data = array($user_id, $signin_user_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
}

function swithFollowButton($dbh, $user_id, $signin_user_id)
{
    $sql = 'SELECT `id` FROM `followers` WHERE `user_id` = ? AND `follower_id` = ?';
    $data = array($user_id, $signin_user_id);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $is_follower = $stmt->fetch(PDO::FETCH_ASSOC);
    return $is_follower;
}

function getfollowers($dbh, $user_id)
{
    $sql = 'SELECT `u`.* FROM `followers` AS `f` LEFT JOIN `users` AS `u` ON `u`.`id` = `f`.`follower_id` WHERE `f`.`user_id` = ?';
    $data = [$user_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $followed = $stmt->fetchall(PDO::FETCH_ASSOC);
    return $followed;
}

function getFollowings($dbh, $user_id)
{
    $sql = 'SELECT `u`.* FROM `followers` AS `f` LEFT JOIN `users` AS `u` ON `u`.`id` = `f`.`user_id` WHERE `f`.`follower_id` = ?';
    $data = [$user_id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $following = $stmt->fetchall(PDO::FETCH_ASSOC);
    return $following;
}