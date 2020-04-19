<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

require "../src/databases/UsersDB.php";
require "../src/ValidatorManager.php";
require "../src/UserManager.php";

set_time_limit(100000);
$user = "Boot";
$password = "wwwwww";
$information = "Hi I'm a boot";
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

if ($hashedPassword == false || $hashedPassword === false) {
  echo "ERROR: Unknown error, try with another password";
  exit();
}

$i = 0;

while ($i < 100) {
  try {
    // -------------------- GET CONNECTION AND VALIDATE DATA -------------------- //
    $conn = UsersDB::newInstance();
    
    // -------------------- REGISTER USER -------------------- //
    $catData = getCatData();
    $result = $conn->prepare("INSERT INTO register (user, password, information) VALUES (?, ?, ?)");
    
    $result->execute(array($user, $hashedPassword, $information));
    
    $result = $conn->query("SELECT LAST_INSERT_ID()");
    $userId = $result->fetchAll()[0]["LAST_INSERT_ID()"];
    
    if ($userId < 1) {
      throw new PDOException("Error Processing Request", 1);
    }
    $conn->exec("INSERT INTO user_data (user_id, new_messages) VALUES ('$userId', '[]')");
    $conn->exec("INSERT INTO wk_ud (user_id, categories, write_test) VALUES ('$userId', '$catData', '[]')");
    
    // -------------------- CONFIG USER -------------------- //
    $userFolder = $userId . bin2hex($user);
    $userFolderAbs = "users/$userFolder";
    
    if (!mkdir($userFolderAbs)) {
      throw new PDOException("Error Processing Request folder", 1);
    }
    
    $msg = "Congrats";
    
    UserManager::sendMessage($conn, 0, $userId, $msg);
  }
  catch (PDOException $e) {
    echo "Couldn't register $e";
    exit();
  }
  $i++;
}

function getCatData() {
  return '{"_1":{"progress":0,"score":0,"cps":[]},"_2":{"progress":0,"score":0,"cps":[]},"_3":{"progress":0,"score":0,"cps":[]},"_4":{"progress":0,"score":0,"cps":[]},"_5":{"progress":0,"score":0,"cps":[]},"_6":{"progress":0,"score":0,"cps":[]},"_7":{"progress":0,"score":0,"cps":[]},"_8":{"progress":0,"score":0,"cps":[]}}';
}
