<?php

require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../database/users.class.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FEUP-reUSE - Register</title>
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
        <div id="signup">
            <a href="../pages/register.php">Register</a>
            <a href="../pages/login.php">Login</a>
        </div>
    </header>

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

    <section id="register">
        <h2>Register</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            
            $name = $firstname . ' ' . $lastname;
            
            $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

            $db = getDatabaseConnection();
            $stmt = $db->prepare('INSERT INTO Users (username, name, email, password) VALUES (?, ?, ?, ?)');
            $stmt->execute([$username, $name, $email, $hashedpassword]);
            
            header("Location: login.php");
            exit();
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label>
                Username <input type="text" name="username" required>
            </label>
            <label>
                First Name <input type="text" name="firstname" required>
            </label>
            <label>
                Last Name <input type="text" name="lastname" required>
            </label>
            <label>
                Email <input type="email" name="email" required>
            </label>
            <label>
                Password <input type="password" name="password" required>
            </label>
            <button type="submit">Register</button>
        </form>
    </section>

    <footer>
        <p>&copy; FEUP-reUSE, 2024</p>
    </footer>
</body>
</html>
