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
