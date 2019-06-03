<?php

function createUser($dbh, $name, $email, $password, $img_name) {
    $sql = "INSERT INTO `users` SET `name` = ?, `email` = ?, `password` = ?, `img_name` = ?, `created` = NOW()";
    $data = array($name, $email, password_hash($password, PASSWORD_DEFAULT), $img_name, );
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
}
