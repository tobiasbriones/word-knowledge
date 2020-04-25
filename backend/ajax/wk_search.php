<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

require "../Src/Database/WKDataDB.php";

if (!isset($_POST["word"])) {
    exit();
}

header("Content-Type: application/json;charset: utf-8");
$categories = [
    "About grammar", "Foods & Meals", "Miscellaneous", "Nature",
    "Parts of things", "People", "Places",
    "Products & Things", "Technicalities & Tools"
];
$found = array();
$searchFor = $_POST["word"];

try {
    $conn = WKDataDB::newInstance();
    
    $i = 1;
    foreach ($categories as $category) {
        $query = "
      SELECT english, spanish
      FROM cat_$i
      WHERE MATCH (english, spanish) AGAINST (? IN BOOLEAN MODE) LIMIT 1
    ";
        //$query = "SELECT english, spanish FROM cat_$i WHERE english LIKE ? OR spanish LIKE ?";
        $result = $conn->prepare($query);
        $result->execute(array("$searchFor*"));
        $pairs = $result->fetchAll();
        
        if (count($pairs) > 0) {
            $found[$category] = $pairs;
        }
        $i++;
    }
    $conn = null;
}
catch (PDOException $e) {
    error("Failed to connect $e");
    exit();
}
echo json_encode($found);

function error($msg) {
    echo json_encode(array("error" => $msg));
}
