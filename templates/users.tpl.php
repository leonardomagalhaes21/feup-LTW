<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/users.class.php')
?>

<?php function drawProfile($user) {
        $loggedId = $_SESSION['id'] ?? null;
        $condition = $loggedId === $user->idUser;
    ?>
    <section id="user-profile">
        <div class="profile-info">
            <img src="https://picsum.photos/200" alt="<?=$user->name?> Profle Picture">
            <div class="profile-details">
                <h2><?=$user->name?></h2>
                <p>Email: <?=$user->email?></p>
            </div>
        </div>
        <?php if ($condition) { ?>
        <div class="profile-content">
            <div class="profile-actions">
                <a href="#">User Details</a>
                <a href="#">Wishlist</a>
                <a href="#">Your Items</a>
                <a href="#">Your Orders</a>
                <a href="../actions/action_logout.php">Logout</a>
            </div>
            <!-- completar depois com ajax -->
        </div>
        <?php } ?>
    </section>
<?php } ?>