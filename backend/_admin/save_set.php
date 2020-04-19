<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

require "../src/databases/WKDataDB.php";
require "../src/object/wk/Category.php";

$categoryId = $_POST['cat'];
$added = array();
$message = "";

try {
  $conn = WKDataDB::newInstance();
  $category = new Category($conn, $categoryId);
  
  foreach ($category->subcategories as $subcategory) {
    $format = str_replace(' ', '_', $subcategory);
    
    if (isset($_POST[$format])) {
      $trim = trim($_POST[$format]);
      
      if (!empty($trim)) {
        $request_array = decode($trim);
        
        foreach ($request_array as $pair) {
          if ($pair != null) {
            if (!exists($conn, $categoryId, $pair->english)) {
              $result = $conn->prepare(
                "INSERT INTO cat_$category->id
								(english, spanish, subcategory) VALUES (?, ?, ?)"
              );
              
              $result->execute(array($pair->english, $pair->spanish, $subcategory));
              $added[] = $pair;
            }
          }
        }
      }
    }
  }
  
  if (count($added) != 0) {
    $message = "Your request have been sent:<br>";
    
    foreach ($added as $pair) {
      $message .= "<strong>$pair->english - $pair->spanish</strong><br>";
    }
  }
  else {
    $message = "Sorry! None of your requests could be sent, perhaps longer exist or did wrong when you type.";
  }
  header("Location: set.php?m=$message");
}
catch (PDOException $e) {
  echo "Failed to send";
  exit();
}

function decode($request) {
  $len = strlen($request);
  $pairs = array();
  $chain = "";
  
  for ($i = 0; $i < $len; $i++) {
    $char = $request[$i];
    
    if ($char == ',') {
      $pairs[] = get_pair($chain);
      $chain = "";
      continue;
    }
    $chain .= $char;
  }
  if (!empty($chain)) {
    $pairs[] = get_pair($chain);
  }
  return $pairs;
}

function get_pair($chain) {
  $pair = new stdClass();
  $pos = strpos($chain, "-");
  
  if (!$pos) {
    return null;
  }
  $english = trim(substr($chain, 0, $pos));
  $spanish = trim(substr($chain, $pos + 1, strlen($chain)));
  
  if (empty($english) || empty($spanish)) {
    return null;
  }
  $pair->english = strtolower($english);
  $pair->spanish = strtolower($spanish);
  return $pair;
}

function exists($conn, $category, $english) {
  $result = $conn->prepare("SELECT id FROM cat_$category WHERE english = ?");
  $result->execute(array($english));
  $rows = $result->fetchAll();
  
  if (count($rows) != 0) {
    return true;
  }
  return false;
}
