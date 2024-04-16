<?php 
  declare(strict_types = 1); 
    //$isLoggedIn = true; // Ou substitua por lógica para verificar se o usuário está logado
    //drawHeader($isLoggedIn);
  function drawHeader($session) { ?>
    <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FEUP-reUSE</title>
        <link rel="icon" href="docs/images/REuse-mini.png">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/layout.css">
        <link rel="stylesheet" href="../css/responsive.css">
      </head>
      <body>
        <header>
          <h1>
              <a href="../pages/index.php">RE<strong>USE</strong></a>
          </h1>
          <?php 
            if ($session->isLoggedIn()) {
          ?>
              <div id="user-icons">
                <a href="../pages/messages.php"><img src="../docs/images/icon_chat.svg" alt="Messages"></a>
                <a href="../pages/add_publication.php"><img src="../docs/images/icon_add.svg" alt="Add Publication"></a>
                <a href="#"><img src="../docs/images/icon_cart.svg" alt="Cart"></a>
                <a href="../pages/user-profile.php"><img src="../docs/images/icon_profile.svg" alt="Profile"></a>
              </div>
          <?php 
            } else {
          ?>
              <div id="signup">
                  <a href="../pages/register.php">Register</a>
                  <a href="../pages/login.php">Login</a>
              </div>
          <?php 
            }
          ?>
        </header>
    <?php } ?>
    
    <?php function drawFooter() { ?>
        </section>
        <footer>
            <p>&copy; FEUP-reUSE, 2024</p>
        </footer>
      </body>
    </html>
    <?php } ?>

