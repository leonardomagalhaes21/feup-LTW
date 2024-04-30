<?php 
    declare(strict_types = 1); 
    require_once(__DIR__ . '/../database/users.class.php');
?>

<?php 
    function drawProfile($db, $user) {
        $loggedId = $_SESSION['id'] ?? null;
        $condition = $loggedId === $user->idUser;
        $profileImage = $user->getProfileImage($db);
?>

<section id="user-profile">
    <div class="profile-info">
        <?php if ($profileImage) { ?>
            <img src="<?= htmlentities((string)$profileImage) ?>" alt="<?= htmlentities($user->name) ?> Profile Picture">
        <?php } else { ?>
            <img src="../docs/images/default_profile_picture.png" alt="<?= htmlentities($user->name) ?> Profile Picture">
        <?php } ?>
        <div class="profile-details">
            <h2><?= htmlentities($user->name) ?></h2>
            <p>Email: <?= htmlentities($user->email) ?></p>
            <p>Username: <?= htmlentities($user->username) ?> </p>
        </div>
    </div>
    <?php if ($condition) { ?>
    <div class="profile-content">
        <div class="profile-actions">
            <a href="#" id="user-details">User Details</a>
            <a href="#" id="wishlist">Wishlist</a>
            <a href="#" id="your-items">Your Items</a>
            <a href="#" id="your-orders">Your Orders</a>
            <a href="#" id="orders-to-ship">Orders to Ship</a>
            <?php if ($user->isAdmin) { ?>
                <a href="#" id="admin-page">Admin Panel</a>
            <?php } ?>
            <a href="../actions/action_logout.php">Logout</a>
        </div>
        <div id="content-container"></div>
        <div id="admin-content-container"></div>
    </div>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    function loadContent(url, containerId) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    document.getElementById(containerId).innerHTML = xhr.responseText;
                } else {
                    console.error(xhr.statusText);
                }
            }
        };
        xhr.send();
    }

    document.getElementById('user-details').addEventListener('click', function(e) {
        e.preventDefault(); 
        document.getElementById('admin-content-container').innerHTML = '';
        loadContent('profile_user_details.php', 'content-container'); 
        //meter  entities para ver segurança no inner html
    });

    document.getElementById('wishlist').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('admin-content-container').innerHTML = '';
        loadContent('wishlist.php', 'content-container');
    });

    document.getElementById('your-items').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('admin-content-container').innerHTML = '';
        loadContent('profile_your_items.php', 'content-container');
    });

    document.getElementById('your-orders').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('admin-content-container').innerHTML = '';
        loadContent('profile_your_orders.php', 'content-container');
    });

    document.getElementById('orders-to-ship').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('admin-content-container').innerHTML = '';
        loadContent('profile_orders_to_ship.php', 'content-container');
    });

    <?php if ($user->isAdmin) { ?>
        document.getElementById('admin-page').addEventListener('click', function(e) {
            e.preventDefault(); 
            document.getElementById('content-container').innerHTML = '';
            loadContent('admin-page.php', 'admin-content-container');
        });
    <?php } ?>
});
</script>


    <?php } ?>
</section>
<?php } ?>