<?php 
  declare(strict_types = 1); 
    //$isLoggedIn = true; // Ou substitua por lógica para verificar se o usuário está logado
    //drawHeader($isLoggedIn);
?>

<?php function drawHeader($session) { ?>
  <!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>FEUP-reUSE</title>
      <link rel="icon" href="../docs/images/REuse-mini.png">
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
              <a href="../pages/user-profile.php?idUser=<?=$_SESSION['id']?>"><img src="../docs/images/icon_profile.svg" alt="Profile"></a>
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

<?php function drawCategories($categories) { ?>
    <nav id="menu">
        <ul>
            <?php foreach ($categories as $category) { ?>
                <li><a href="../pages/index.php"><?= $category->categoryName ?></a></li>
            <?php } ?>
        </ul>
    </nav>
<?php } ?>

<?php function drawSearchAndFilter() {  // precisa de melhorar ?>
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
<?php } ?>

<?php function drawFooter() { ?>
    <footer>
        <p>&copy; FEUP-reUSE, 2024</p>
    </footer>
  </body>
</html>
<?php } ?>

