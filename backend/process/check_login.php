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

if (!isset($_POST["send"]) || !isset($_POST["user"]) || !isset($_POST["password"])) {
    redirect("../login.php");
    exit();
}

$user = $_POST["user"];
$password = $_POST["password"];

try {
    $conn = UsersDB::newInstance();
    $result = $conn->prepare("SELECT user_id, password FROM register WHERE user = ?");
    
    $result->execute(array($user));
    $rows = $result->fetchAll();
    
    if (count($rows) != 1) {
        redirect("../../login.php?w");
        exit();
    }
    $userRow = $rows[0];
    
    if (password_verify($password, $userRow["password"])) {
        if (isset($_POST["remember"])) {
            UserManager::loginUser($userRow["user_id"], true);
        }
        else {
            UserManager::loginUser($userRow["user_id"], false);
        }
        redirect("../../index.php");
        exit();
    }
    else {
        redirect("../../login.php?w");
    }
}
catch (PDOException $e) {
    redirect("../../login.php?e");
    exit();
}

function redirect($path) {
    header("Location: $path");
}
