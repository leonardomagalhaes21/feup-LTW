<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/item.class.php')
?>

<?php function drawProfile($user) { //meter condiçao para apenas mostrar o profile content se o id fôr o do user atual ?>
    <section id="user-profile">
        <div class="profile-info">
            <img src="https://picsum.photos/200" alt="<?=$user->name?> Profle Picture">
            <div class="profile-details">
                <h2>Name: <?=$user->name?></h2>
                <p>Email: <?=$user->email?></p>
            </div>
        </div>
        <div class="profile-content">
            <div class="profile-actions">
                <a href="#">User Details</a>
                <a href="#">Wishlist</a>
                <a href="#">Your Orders</a>
            </div>
            <!-- completar depois com ajax -->
        </div>
    </section>
<?php } ?>