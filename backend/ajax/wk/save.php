<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

require "../../src/database/UsersDB.php";
require "../../src/UserManager.php";
require "../../src/WKUserManager.php";

if (!isset($_POST["category"]) || !isset($_POST["cps"]) || !is_numeric($_POST["category"])) {
    exit();
}

$category = $_POST["category"];
$cps = $_POST["cps"];

try {
    $userId = UserManager::retrieveUserId();
    
    if ($userId == UserManager::NO_USER) {
        exit();
    }
    $conn = UsersDB::newInstance();
    
    WKUserManager::saveProgress($conn, $userId, $category, $cps);
    $conn = null;
}
catch (PDOException $e) {
    exit();
}
