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
