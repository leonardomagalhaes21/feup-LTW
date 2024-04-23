<?php
require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/users.class.php');

require_once(__DIR__ . '/../templates/common.tpl.php');

$db = getDatabaseConnection();

if (!User::isAdmin($db, $session->getId())) {
    header("Location: ../pages/index.php");
    exit();
}

drawHeader($session);
?>  


<section id="admin">
    <article>
        <h2>Elevate User to Admin Status</h2>
        <form action="../actions/action_elevate_user.php" method="post">
            <?php  
                if (isset($_SESSION['message'])) {
                    echo "<p>{$_SESSION['message']}</p>";
                    unset($_SESSION['message']);
                }
            ?>
            <label for="user_search">Search User:</label>
            <input type="text" id="user_search" name="user_search" placeholder="Search for a user...">
            <div id="user_list">
                <?php
                $users = User::getAllUsers($db);

                foreach ($users as $user) {
                    if ($user->isAdmin){
                        echo "<div><input type='radio' id='user_{$user->idUser}' name='user_id' value='{$user->idUser}'><label for='user_{$user->idUser}'>{$user->username} ({$user->name}) - <strong>Admin</strong></label></div>";
                    }
                    else {
                        echo "<div><input type='radio' id='user_{$user->idUser}' name='user_id' value='{$user->idUser}'><label for='user_{$user->idUser}'>{$user->username} ({$user->name})</label></div>";
                    
                    }
                }
                ?>
            </div>
            <button type="submit">Elevate to Admin</button>
        </form>
    </article>




    <article>
        <h2>Add New Categories, Sizes, Conditions, ...</h2>
        <div>
            <h3>Add New Category</h3>
            <form action="../actions/action_add_category.php" method="post">
                <label for="categoryName">Category Name:</label>
                <input type="text" id="categoryName" name="categoryName" required>
                <button type="submit">Add Category</button>
            </form>
        </div>
    </article>


    <article>
        <h2>System Operation Overview</h2>
    </article>

</section>

<?php
drawFooter();
?>
