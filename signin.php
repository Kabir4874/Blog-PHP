<?php
require 'config/constants.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blog Application - PHP</title>
  <!-- ?custom css  -->
  <link rel="stylesheet" href="styles/style.css" />
  <!-- ?unicons cdn -->
  <link
    rel="stylesheet"
    href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" />
</head>

<body>
  <section class="form_section">
    <div class="container form_section-container">
      <h2>Sign In</h2>
      <?php
      if (isset($_SESSION['signup-success'])): ?>
        <div class="alert_message success">
          <p>
            <?= $_SESSION['signup-success'];
            unset($_SESSION['signup-success']) ?>
          </p>
        </div>
      <?php endif ?>
      <form action="<?= ROOT_URL ?>signin-logic.php" method="POST">
        <input type="text" name="username_email" placeholder="Username or Email" />
        <input type="password" name="password" placeholder="Password" />
        <button type="submit" name="submit" class="btn">Sign In</button>
        <small>Don't have account? <a href="signup.php">Sign Up</a></small>
      </form>
    </div>
  </section>

  <script src="scripts/main.js"></script>
</body>

</html>