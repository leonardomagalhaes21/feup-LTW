<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/users.class.php')
?>

<?php function drawProfile($db, $user) {
        $loggedId = $_SESSION['id'] ?? null;
        $condition = $loggedId === $user->idUser;
        $profileImage = $user->getProfileImage($db);
    ?>
    <section id="user-profile">
        <div class="profile-info">
            <?php if ($profileImage) { ?>
                <img src="<?=$profileImage?>" alt="<?=$user->name?> Profle Picture">
            <?php } else { ?>
                <img src="../docs/images/default_profile_picture.png" alt="<?=$user->name?> Profle Picture">
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
            <div id="content-container">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script>
                $(document).ready(function() {
                    function loadContent(url) {
                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function(response) {
                                $('#content-container').html(response);
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    }

                    loadContent('profile_user_details.php');

                    $('#user-details').click(function(e) {
                        e.preventDefault(); 
                        loadContent('profile_user_details.php'); 
                    });

                    $('#wishlist').click(function(e) {
                        e.preventDefault();
                        loadContent('wishlist.php');
                    });

                    $('#your-items').click(function(e) {
                        e.preventDefault();
                        loadContent('profile_your_items.php');
                    });

                    $('#your-orders').click(function(e) {
                        e.preventDefault();
                        loadContent('profile_your_orders.php');
                    });
                });
                </script>
            </div>
            <!-- completar depois com ajax -->
        </div>

        <?php } ?>
    </section>
<?php } ?>