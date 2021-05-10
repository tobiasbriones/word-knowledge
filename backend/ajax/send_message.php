<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

require "../Src/Database/UsersDB.php";
require "../Src/UserManager.php";
require "../Src/Model/User.php";

if (!isset($_POST["msg"]) || !isset($_POST["receiver"])) {
    exit();
}

$rec = $_POST["receiver"];
$msg = $_POST["msg"];

try {
    $conn = UsersDB::newInstance();
    $senderId = UserManager::retrieveUserId();
    $recId = User::findUserByName($conn, $rec)->id;

    if ($senderId == UserManager::NO_USER || $recId == null) {
        exit();
    }
    UserManager::sendMessage($conn, $senderId, $recId, $msg);
    $conn = null;
}
catch (PDOException $e) {
    echo "Failed to send";
    exit();
}
