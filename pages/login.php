<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();


    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/category.class.php');
    require_once __DIR__ . '/../database/users.class.php';

    require_once(__DIR__ . '/../templates/common.tpl.php');


    $db = getDatabaseConnection();

    $categories = Category::getCategories($db);

    drawHeader($session);
    drawCategories($categories);


?>

    <section id="login">
        <h2>Login</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $password = $_POST["password"];
            
            try {
                if (User::userExists($username, $password)) {
                    $_SESSION['id'] = User::getUserByUsername($db, $username)->idUser;
                    $_SESSION['name'] = User::getUserByUsername($db, $username)->usename;
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Login failed";
                }
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            }
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label>
                Username <input type="text" name="username" required>
            </label>
            <label>
                Password <input type="password" name="password" required>
            </label>
            <button type="submit">Login</button>
        </form>
    </section>

    <footer>
        <p>&copy; FEUP-reUSE, 2024</p>
    </footer>
</body>
</html>
