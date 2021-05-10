<!--
  -- Copyright (c) 2015 Tobias Briones
  -- All rights reserved.
  --
  -- This source code is licensed under the BSD 3-Clause license found in the
  -- LICENSE file in the root directory of this source tree.
  -->

<!doctype html>
<html lang="en">

  <head>
    <title>Login</title>
    <link rel="stylesheet"
          type="text/css"
          href="libs/materialize/css/materialize.min.css"
          media="screen,projection">
    <link rel="stylesheet" type="text/css" href="css/default.css">
    <link rel="stylesheet" type="text/css" href="css/form.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
  </head>

  <body>

    <div class="container row">
      <div class="col s12 m6 l4" id="main">
        <div id="wrong">
            <?php
            if (isset($_GET['e'])) {
                echo "<p>An error has occurred, please retry again</p>";
            }
            if (isset($_GET['w'])) {
                echo "<p>The username/password don't match</p>";
            }
            ?>
        </div>

        <form method="post" action="backend/process/check_login.php">
          <div class="row">
            <div class="input-field col s12">
              <input class="white-text" id="user" name="user" type="text">
              <label for="user">User</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input class="white-text" id="password" name="password" type="password">
              <label for="password">Password</label>
            </div>
          </div>

          <p>
            <label>
              <input id="remember"
                     name="remember"
                     type="checkbox"
                     class="filled-in"
                     checked="checked">
              <span>Remember</span>
            </label>
          </p>

          <input class="btn blue darken-4" type="submit" name="send" value="log in">
        </form>

        <div class="row noa">
          <p>You don't have an account?</p>
          <a href="register.php">Register</a>
        </div>

      </div>
    </div>

  </body>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script>
    window.jQuery ||
    document.write('<script src="libs/jquery-dist-2.1.4/jquery.min.js"><\/script>');
  </script>
  <script src="libs/materialize/js/materialize.min.js"></script>

</html>
