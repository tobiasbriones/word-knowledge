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

pre();

$user = $_POST["user"];
$password = $_POST["password"];
$confirmPassword = $_POST["confirm_password"];
$avatarUploaded = $_FILES["avatar"]["tmp_name"];
$information = $_POST["information"];
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

if ($hashedPassword == false || $hashedPassword === false) {
  echo "ERROR: Unknown error, try with another password";
  exit();
}

try {
  // -------------------- GET CONNECTION AND VALIDATE DATA -------------------- //
  $conn = UsersDB::newInstance();
  $allOk = true;
  $errors = "";
  
  $allOk &= ValidatorManager::isValidUser($conn, $user, $errors);
  $allOk &= ValidatorManager::isValidPassword($password, $confirmPassword, $errors);
  $allOk &= ValidatorManager::isValidUserInfo($information, $errors);
  
  if ($allOk == false) {
    echo $errors;
    exit();
  }
  
  // -------------------- REGISTER USER -------------------- //
  $catData = getCatData();
  $result = $conn->prepare("INSERT INTO register (user, password, information) VALUES (?, ?, ?)");
  
  $result->execute(array($user, $hashedPassword, $information));
  
  $result = $conn->query("SELECT LAST_INSERT_ID()");
  $userId = $result->fetchAll()[0]["LAST_INSERT_ID()"];
  
  // The first user is the Word Knowledge system with id 0
  if ($userId < 1) {
    throw new PDOException("Error Processing Request", 1);
  }
  $conn->exec("INSERT INTO user_data (user_id, new_messages) VALUES ('$userId', '[]')");
  $conn->exec("INSERT INTO wk_ud (user_id, categories, write_test) VALUES ('$userId', '$catData', '[]')");
  
  // -------------------- CONFIG USER -------------------- //
  $userStorageFolder = "../storage/users/";
  $userFolderName = $userId . bin2hex($user);
  $userFolder = $userStorageFolder . $userFolderName;
  
  if (!mkdir($userFolder)) {
    throw new PDOException("Error Processing Request", 1);
  }
  
  if (ValidatorManager::isValidAvatar($avatarUploaded, $errors)) {
    $avatarTargetFile = $userFolder . "/avatar";
    
    move_uploaded_file($avatarUploaded, $avatarTargetFile);
  }
  $msg = "Congrats";
  
  UserManager::sendMessage($conn, 1, $userId, $msg);
  header("Location: ../../login.php");
}
catch (PDOException $e) {
  echo "Couldn't register $e";
  exit();
}

function pre() {
  if (!isset($_POST["send"]) || !isset($_POST["user"]) || !isset($_POST["password"])
      || !isset($_POST["confirm_password"])) {
    header("Location: ../../register.php");
    exit();
  }
}

function getCatData() {
  return '{"_1":{"progress":0,"score":0,"cps":[]},"_2":{"progress":0,"score":0,"cps":[]},"_3":{"progress":0,"score":0,"cps":[]},"_4":{"progress":0,"score":0,"cps":[]},"_5":{"progress":0,"score":0,"cps":[]},"_6":{"progress":0,"score":0,"cps":[]},"_7":{"progress":0,"score":0,"cps":[]},"_8":{"progress":0,"score":0,"cps":[]}}';
}
