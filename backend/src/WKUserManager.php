<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

class WKUserManager {
  
  public static function saveProgress($conn, $userId, $category, $checkPoints) {
    $result = $conn->query("SELECT UD.score, WKUD.categories FROM user_data UD INNER JOIN wk_ud WKUD ON UD.user_id = WKUD.user_id WHERE UD.user_id = '$userId'");
    $rows = $result->fetchAll();
    
    if (count($rows) != 1) {
      return false;
    }
    
    $userRow = $rows[0];
    $categories = $userRow["categories"];
    $categoriesJSON = json_decode($categories, true);
    $categoryJSON = &$categoriesJSON["_$category"];
    $globalScore = $userRow["score"];
    
    foreach ($checkPoints as $checkPoint) {
      $score = WKUserManager::getScore($checkPoint["fails"]);
      $pair = $checkPoint["pair"];
      
      $categoryJSON["progress"]++;
      $categoryJSON["score"] += $score;
      $categoryJSON["cps"][] = $pair;
      $globalScore += $score;
    }
    
    $categories = json_encode($categoriesJSON);
    
    $conn->exec("UPDATE user_data SET score = '$globalScore' WHERE user_id = '$userId'");
    $conn->exec("UPDATE wk_ud SET categories = '$categories' WHERE user_id = '$userId'");
    return true;
  }
  
  private static function getScore($fails) {
    $score = (100) - (50 * $fails);
    
    if ($score < -100) {
      $score = -100;
    }
    return $score;
  }
  
  public static function resetProgress($conn, $userId, $category) {
    $result = $conn->query("SELECT categories FROM wk_ud WHERE user_id = '$userId'");
    $rows = $result->fetchAll();
    
    if (count($rows) != 1) {
      return false;
    }
    $userCategories = $rows[0]["categories"];
    $categoriesJSON = json_decode($userCategories, true);
    $categoryJSON = &$categoriesJSON["_$category"];
    
    $categoryJSON["cps"] = array();
    $userCategories = json_encode($categoriesJSON);
    
    $conn->exec("UPDATE wk_ud SET categories = '$userCategories' WHERE user_id = '$userId'");
    return true;
  }
  
  public static function getCheckPoints($conn, $userId, $category) {
    $categoryJSON = WKUserManager::getProgress($conn, $userId, $category);
    
    return $categoryJSON["cps"];
  }
  
  public static function getProgress($conn, $userId, $category) {
    $result = $conn->query("SELECT categories FROM wk_ud WHERE user_id = '$userId'");
    $rows = $result->fetchAll();
    
    if (count($rows) != 1) {
      return null;
    }
    $userCategories = $rows[0]["categories"];
    $categoriesJSON = json_decode($userCategories, true);
    
    return $categoriesJSON["_$category"];
  }
  
}
