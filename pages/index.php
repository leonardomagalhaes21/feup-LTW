<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    require_once(__DIR__ . '/../templates/common.tpl.php');

    drawHeader($session);
?>
    <nav id="menu">
        <ul>
            <li><a href="../pages/index.php">&#128187; Electronics</a></li>
            <li><a href="../pages/index.php">&#128084; Clothing</a></li>
            <li><a href="../pages/index.php">&#129681; Furniture</a></li>
            <li><a href="../pages/index.php">&#128218; Books</a></li>
            <li><a href="../pages/index.php">&#127918; Games</a></li>
            <li><a href="../pages/index.php">&#9917; Sports</a></li>
            <li><a href="../pages/index.php">&#128250; Houseware</a></li>
            <li><a href="../pages/index.php">&#128259; Others</a></li>
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
        <article>
            <a href="../pages/item.php">
                <img src="https://picsum.photos/200?theme=phone" alt="Smartphone Image">
            </a>
            <div class="item-details">
                <h2>
                    <a href="../pages/item.php">Smartphone</a>
                </h2>
                <p>A gently used smartphone in excellent condition. Comes with charger and original packaging.</p>
                <p>Price: 200€</p>
            </div>
        </article>
        <article>
            <a href="../pages/item.php">
                <img src="https://picsum.photos/200?theme=sports" alt="Bicycle Image">
            </a>
            <div class="item-details">
                <h2>
                    <a href="../pages/item.php">Bicycle</a>
                </h2>
                <p>A sturdy bicycle perfect for commuting or leisure rides. Includes a basket for carrying items.</p>
                <p>Price: 150€</p>
            </div>
        </article>
        <article>
            <a href="../pages/item.php">
                <img src="https://picsum.photos/200?theme=technology" alt="Laptop Image">
            </a>
            <div class="item-details">
                <h2>
                    <a href="../pages/item.php">Laptop</a>
                </h2>
                <p>A powerful laptop suitable for work and entertainment. Features a fast processor and ample storage.</p>
                <p>Price: 800€</p>
            </div>
        </article>
        <article>
            <a href="../pages/item.php">
                <img src="https://picsum.photos/200?theme=dress" alt="Dress Image">
            </a>
            <div class="item-details">
                <h2>
                    <a href="../pages/item.php">Elegant Dress</a>
                </h2>
                <p>An elegant dress perfect for formal occasions or evening events. Made from high-quality fabric with exquisite design details.</p>
                <p>Price: 120€</p>
            </div>
        </article>
        <article>
            <a href="../pages/item.php">
                <img src="https://picsum.photos/200?theme=shoes" alt="Stylish Shoes Image">
            </a>
            <div class="item-details">
                <h2>
                    <a href="../pages/item.php">Stylish Shoes</a>
                </h2>
                <p>A pair of stylish and comfortable shoes suitable for everyday wear. Features durable material and a sleek design.</p>
                <p>Price: 70€</p>
            </div>
        </article>
    </section>
    <footer>
        <p>&copy; FEUP-reUSE, 2024</p>
    </footer>
</body>
</html>