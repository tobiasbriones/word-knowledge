<!--
  -- Copyright (c) 2015 Tobias Briones
  -- All rights reserved.
  --
  -- This source code is licensed under the BSD 3-Clause license found in the
  -- LICENSE file in the root directory of this source tree.
  -->

<?php
require "../Src/databases/WKDataDB.php";
require "../Src/object/WK/Category.php";

$categories = array();

try {
    $conn = WKDataDB::newInstance();

    for ($i = 1; $i < 10; $i++) {
        $categories[] = new Category($conn, $i, false);
    }
    $conn = null;
}
catch (PDOException $e) {
    echo "error <br>$e";
    exit();
}
?>

<!doctype html>
<html lang="en">

  <head>
    <title>Uploader</title>
    <link rel="stylesheet"
          type="text/css"
          href="../../libs/materialize/css/materialize.min.css"
          media="screen,
    projection">
    <link rel="stylesheet" type="text/css" href="../../css/default.css">
    <link rel="stylesheet" type="text/css" href="../../css/uploader.css">
    <meta charset="UTF-8">
  </head>

  <body>

    <div class="categories">
      <ul>
          <?php
          foreach ($categories as $category) {
              echo "<li data-cat='$category->id'><span class='center'>$category->name</span></li>";
          }
          ?>
      </ul>
    </div>

    <div class="container">
      <div id="editor"></div>
    </div>

    <div class="advices">
      <ul>
        <li>
          Please write correctly, with punctuation marks if
          necessary & every letter in lowercase
        </li>

        <li>
          Put them in the correct subcategory please!
        </li>

        <li>
          You've to send before change of category,
          otherwise you'll lose it
        </li>

      </ul>

      <ul>
        <p>Samples</p>
        <li>
          * casa-house, bicycle-bicicleta, blue-azul
        </li>

        <li>
          * key - tecla, bottle-botella
        </li>
      </ul>
      <p>
        FIRST ENGLISH, THEN SPANISH
      </p>

    </div>

    <div class="message card-panel blue-grey"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="../../libs/materialize/js/materialize.min.js"></script>
    <script>
      let editor = null;

      $(document).on('ready', function () {
        editor = $('#editor');
        const categories = $('.categories li');

        categories.each(function () {
          $(this).click(onCategory);
        });
        const m = getUrlParameter('m');

        if (m != null) {
          const mi = $('.message');

          mi.css('display', 'block');
          mi.html(m);
          setTimeout(function () {
            mi.css('display', 'none');
          }, 5000);
        }
        categories.triggerHandler('click');
      });

      function onCategory() {
        const id = $(this).data('cat');

        load(id);
      }

      function load(category) {
        editor.html('Loading');
        $.post('bring_set.php', { 'category': category }).done(function (data) {
          editor.html(data);
        });
      }

      function getUrlParameter(param) {
        const pageURL = decodeURIComponent(window.location.search.substring(1));
        const urlParams = pageURL.split('&');

        for (let i = 0; i < urlParams.length; i++) {
          const paramName = urlParams[i].split('=');

          if (paramName[0] === param) {
            return paramName[1] === undefined ? true : paramName[1];
          }
        }
      }
    </script>

  </body>

</html>
