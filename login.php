<?php
require_once 'database/connection.db.php';
require_once 'database/users.class.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FEUP-reUSE - Login</title>
    <link rel="icon" href="docs/images/REuse-mini.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>
    <header>
        <h1>
            <a href="index.php">RE<strong>USE</strong></a>
        </h1>
        <div id="signup">
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
        </div>
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

    <section id="login">
        <h2>Login</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $password = $_POST["password"];
            
            try {
                if (User::userExists($username, $password)) {
                    echo "Login successful"; 
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
