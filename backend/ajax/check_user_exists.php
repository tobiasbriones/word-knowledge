<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

require "../src/database/UsersDB.php";
require "../src/ValidatorManager.php";

if (!isset($_POST["user"])) {
    exit();
}

header("Content-type: text/html; charset=utf-8");
$user = $_POST["user"];

try {
    $conn = UsersDB::newInstance();
    $exists = ValidatorManager::exists($conn, $user);
    
    if ($exists) {
        echo "true";
    }
    else {
        echo "false";
    }
    $conn = null;
}
catch (PDOException $e) {
    echo "Error when connecting";
    exit();
}
