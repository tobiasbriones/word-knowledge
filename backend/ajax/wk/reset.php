<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

require "../../src/databases/UsersDB.php";
require "../../src/UserManager.php";
require "../../src/WKUserManager.php";

if (!isset($_POST["category"]) || !is_numeric($_POST["category"])) {
  exit();
}

$category = $_POST["category"];

try {
  $conn = UsersDB::newInstance();
  $userId = UserManager::retriveUserId();
  
  if ($userId == UserManager::NO_USER) {
    exit();
  }
  $result = $conn->query("SELECT categories FROM wk_ud WHERE user_id = '$userId'");
  $rows = $result->fetchAll();
  
  if (count($rows) != 1) {
    return null;
  }
  $userCategories = $rows[0]["categories"];
  $categoriesJSON = json_decode($userCategories, true);
  $categoryJSON = &$categoriesJSON["_$category"];
  
  $categoryJSON["progress"] = 0;
  $categoryJSON["score"] = 0;
  $categoryJSON["cps"] = array();
  
  $userCategories = json_encode($categoriesJSON);
  $conn->exec("UPDATE wk_ud SET categories = '$userCategories' WHERE user_id = '$userId'");
}
catch (PDOException $e) {
  exit();
}
