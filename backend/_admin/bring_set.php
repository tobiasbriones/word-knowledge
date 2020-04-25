<!--
  -- Copyright (c) 2015 Tobias Briones
  -- All rights reserved.
  --
  -- This source code is licensed under the BSD 3-Clause license found in the
  -- LICENSE file in the root directory of this source tree.
  -->

<?php
$categoryId = $_POST["category"];

if (!is_numeric($categoryId)) {
    exit();
}

require "../Src/databases/WKDataDB.php";
require "../Src/object/WK/Category.php";

$category = null;

try {
    $conn = WKDataDB::newInstance();
    $category = new Category($conn, $categoryId, false);
    
    $conn = null;
}
catch (PDOException $e) {
    echo "error";
    exit();
}

echo "<span class='title'>$category->name</span>";
echo "<form action='save_set.php' method='post'>";
echo "<input type='hidden' name='cat' value='$category->id'/>";

foreach ($category->subcategories as $subcategory) {
    $format = str_replace(" ", "_", $subcategory);
    ?>
  <div class="input-field">
    <textarea id="<?php echo $subcategory; ?>"
              class="materialize-textarea"
              name="<?php echo $format; ?>">
    </textarea>
    <label for="<?php echo $subcategory; ?>">
        <?php echo $subcategory; ?>
    </label>
  </div>
    <?php
}
echo "<input id='s' class='btn green' type='submit' value='send'/>";
echo "</form>";
?>
