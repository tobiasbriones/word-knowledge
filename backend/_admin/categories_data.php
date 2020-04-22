<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

require "../src/databases/WKDataDB.php";

$file = fopen("categories_data.json", "r");
$content = "";

while (!feof($file)) {
    $content .= fgets($file);
}

$categories_json = json_decode($content, true);

if ($categories_json == null) {
    echo "You have an error in your json file";
    exit();
}

try {
    $conn = WKDataDB::newInstance();
    
    echo "Uploading...<br>";
    foreach ($categories_json as $categoryData) {
        $category = $categoryData["category"];
        $data = $categoryData["data"];
        $id = $conn->query("SELECT id FROM reg WHERE name = '$category'")->fetchAll()[0]["id"];

//echo "<br>Category $category<br>";
        foreach ($data as $scData) {
            $sc = $scData["subcategory"];
//echo "=> $sc<br>";
            foreach ($scData["data"] as $pair) {
                $english = $pair["english"];
                $spanish = $pair["spanish"];
//echo "--- ".$pair["english"]." - ".$pair["spanish"]. "<br>";
                $conn->exec("INSERT INTO cat_$id (english, spanish, subcategory) VALUES ('$english', '$spanish', '$sc')");
            }
        }
    }
    echo "Done";
}
catch (PDOException $e) {
    echo "Error processing<br>$e";
    exit();
}
