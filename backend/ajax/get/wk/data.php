<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

require "../../../Src/Database/UsersDB.php";
require "../../../Src/Database/WKDataDB.php";
require "../../../Src/Model/WK/Category.php";
require "../../../Src/UserManager.php";
require "../../../Src/WKUserManager.php";

if (!isset($_POST["category"]) || !is_numeric($_POST["category"])) {
    exit();
}

$categoryId = $_POST["category"];
$response = array();
$userCPS = null;
$category = null;

try {
    $userConn = UsersDB::newInstance();
    $wkConn = WKDataDB::newInstance();
    $userId = UserManager::retrieveUserId();
    $category = new Category($wkConn, $categoryId);
    
    if (!$category->exists) {
        exit();
    }
    $wkConn = null;
    
    if ($userId != UserManager::NO_USER) {
        $userCPS = WKUserManager::getCheckPoints($userConn, $userId, $category->id);
    }
    else {
        $userCPS = array();
    }
    $userConn = null;
}
catch (PDOException $e) {
    exit();
}
$response["game"] = array(
    "pairs" => $category->pairs,
    "subcategories" => $category->subcategories,
    "cps" => $userCPS
);
$response["study"] = getStudyHTML();

header("Content-Type: application/json;charset=utf-8");
echo json_encode($response);

function getStudyHTML() {
    global $category;
    $pairs = array();
    $html = "";
    
    foreach ($category->subcategories as $subcategory) {
        $pairs[$subcategory] = array();
    }
    
    foreach ($category->pairs as $pair) {
        $pairs[$pair["subcategory"]][] = $pair;
    }
    
    foreach ($pairs as $subcategory => $pairs) {
        $html .= "<div class='study-sc'><span>$subcategory</span><ul>";
        
        foreach ($pairs as $pair) {
            $siChain = "$pair[english] <strong>-</strong> $pair[spanish]";
            
            $html .= "<li><span>$siChain</span></li>";
        }
        $html .= "</ul></div>";
    }
    return $html;
}
