<?php
/*
 * Copyright (c) 2015 Tobias Briones
 * All rights reserved.
 *
 * This source code is licensed under the BSD 3-Clause license found in the
 * LICENSE file in the root directory of this source tree.
 */

require "../Src/databases/WKDataDB.php";

$file = fopen("categories.json", "r");
$content = "";

while (!feof($file)) {
    $content .= fgets($file);
}

$categories_json = json_decode($content, true);

if ($categories_json == null) {
    echo "You have an error in your json file";
    exit();
}
$reg_sql = "CREATE TABLE reg (id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
				 name VARCHAR(30) NOT NULL,
				 subcategories VARCHAR(300) NOT NULL,
				 PRIMARY KEY(id))
				 ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;";

try {
    $conn = WKDataDB::newInstance();

    $conn->exec($reg_sql);

    $result = $conn->prepare("INSERT INTO reg (name, subcategories) VALUES (?, ?)");

    $i = 1;
    foreach ($categories_json as $category => $subcategories) {
        $subcategoriesJSON = json_encode($subcategories);

        if (strlen($subcategoriesJSON) > 300) {
            echo "Too much scs in $i";
            exit();
        }
        $result->execute(array($category, $subcategoriesJSON));
        $conn->exec(
            "CREATE TABLE cat_$i
				(id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
				 english VARCHAR(50) NOT NULL,
				 spanish VARCHAR(50) NOT NULL,
				 subcategory VARCHAR(30) NOT NULL,
				 PRIMARY KEY (id))
				 ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;"
        );
        $conn->exec("ALTER TABLE cat_$i ADD FULLTEXT (english, spanish)");
        $i++;
    }
}
catch (PDOException $e) {
    echo "Error processing<br>$e";
    exit();
}
