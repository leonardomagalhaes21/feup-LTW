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
              <a href="index.php">RE<strong>USE</strong></a>
          </h1>
          <?php 
            if ($session->isLoggedIn()) {
          ?>
              <div id="user-icons">
                <a href="profile.php"><img src="icon_profile.svg" alt="Profile"></a>
                <a href="messages.php"><img src="icon_chat.svg" alt="Messages"></a>
                <a href="cart.php"><img src="icon_cart.svg" alt="Cart"></a>
                <a href="add_publication.php"><img src="icon_add.svg" alt="Cart"></a>
              </div>
          <?php 
            } else {
          ?>
              <div id="signup">
                  <a href="register.php">Register</a>
                  <a href="login.php">Login</a>
              </div>
          <?php 
            }
          ?>
        </header>
        <nav id="menu">
          <ul>
            <li><a href="index.php">&#128187; Electronics</a></li>
            <li><a href="index.php">&#128084; Clothing</a></li>
            <li><a href="index.php">&#129681; Furniture</a></li>
            <li><a href="index.php">&#128218; Books</a></li>
            <li><a href="index.php">&#127918; Games</a></li>
            <li><a href="index.php">&#9917; Sports</a></li>
            <li><a href="index.php">&#128250; Houseware</a></li>
            <li><a href="index.php">&#128259; Others</a></li>
          </ul>
        </nav>
        <aside>
          <h2>Search and Filter</h2>
          <form method="get">
            <input type="text" id="search" placeholder="Search here">
            <br>
            <label for="category">Category:</label>
            <select id="category">
              <option value="all" selected>All</option>
              <option value="electronics">Electronics</option>
              <option value="clothing">Clothing</option>
              <option value="furniture">Furniture</option>
              <option value="books">Books</option>
              <option value="toys_games">Toys/Games</option>
              <option value="sporting_goods">Sporting Goods</option>
              <option value="home_appliances">Home Appliances</option>
              <option value="others">Others</option>
            </select>
            <br>
            <label for="order">Order by:</label>
            <select id="order">
              <option value="default" selected>Default</option>
              <option value="price_asc">Price: Low to High</option>
              <option value="price_desc">Price: High to Low</option>
            </select>
            <br>
            <button type="submit">Search</button>
          </form>
        </aside>
        <section id="items">
          <h2>Items for Sale</h2>
    <?php } ?>
    
    <?php function drawFooter() { ?>
        </section>
        <footer>
            <p>&copy; FEUP-reUSE, 2024</p>
        </footer>
      </body>
    </html>
    <?php } ?>

