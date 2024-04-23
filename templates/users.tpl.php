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
            <img src="<?=$profileImage?>" alt="<?=$user->name?> Profile Picture">
        <?php } else { ?>
            <img src="../docs/images/default_profile_picture.png" alt="<?=$user->name?> Profile Picture">
        <?php } ?>
        <div class="profile-details">
            <h2><?=$user->name?></h2>
            <p>Email: <?=$user->email?></p>
            <p>Username: <?=$user->username?> </p>
        </div>
    </div>
    <?php if ($condition) { ?>
    <div class="profile-content">
        <div class="profile-actions">
            <a href="#" id="user-details">User Details</a>
            <a href="#" id="wishlist">Wishlist</a>
            <a href="#" id="your-items">Your Items</a>
            <a href="#" id="your-orders">Your Orders</a>
            <?php if ($user->isAdmin) { ?>
                <a href="../pages/admin-page.php">Admin Panel</a>
            <?php } ?>
            <a href="../actions/action_logout.php">Logout</a>
        </div>
        <div id="content-container"></div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function loadContent(url) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', url, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            document.getElementById('content-container').innerHTML = xhr.responseText;
                        } else {
                            console.error(xhr.statusText);
                        }
                    }
                };
                xhr.send();
            }

            loadContent('profile_user_details.php');

            document.getElementById('user-details').addEventListener('click', function(e) {
                e.preventDefault(); 
                loadContent('profile_user_details.php'); 
            });

            document.getElementById('wishlist').addEventListener('click', function(e) {
                e.preventDefault();
                loadContent('wishlist.php');
            });

            document.getElementById('your-items').addEventListener('click', function(e) {
                e.preventDefault();
                loadContent('profile_your_items.php');
            });

            document.getElementById('your-orders').addEventListener('click', function(e) {
                e.preventDefault();
                loadContent('profile_your_orders.php');
            });
        });
    </script>
    <?php } ?>
</section>
<?php } ?>
