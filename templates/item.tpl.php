<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/item.class.php')
?>

<?php function drawItems(array $items, PDO $db) { ?>
    <section id="items">
        <h2>Items for Sale</h2>
        <?php foreach ($items as $item) { ?>
            <article>
                <?php $mainImagePath = $item->getMainImage($db) ?>
                <a href="../pages/item.php?idItem=<?=$item->idItem?>">
                    <img src="<?=$mainImagePath?>" alt="<?=$item->name?>">
                </a>
                <div class="item-details">
                    <h2>
                        <a href="../pages/item.php?idItem=<?=$item->idItem?>"><?=$item->name?></a>
                    </h2>
                    <p><?=$item->description?></p>
                    <p>Price: $<?=$item->price?></p>
                </div>
            </article>
        <?php } ?>
    </section>
<?php } ?>

<?php function drawItem(PDO $db, Item $item) { ?>
    <section id="item-details">
        <header>
            <button>&#8592; Go Back</button>
            <h2>Item Overview</h2>
        </header>
        <article>
            <?php 
            $mainImagePath = $item->getMainImage($db);
            $secondaryImages = $item->getSecondaryImages($db);
            ?>
            <div class="slideshow">
                <?php 
                echo '<div class="image-slide"><img src="' . $mainImagePath . '" alt="' . $item->name . '"></div>';
    
                foreach ($secondaryImages as $image) {
                    echo '<div class="image-slide"><img src="' . $image['imagePath'] . '" alt="' . $item->name . '"></div>';
                }
                ?>
                <button onclick="plusSlides(-1)">&#10094;</button>
                <button onclick="plusSlides(1)">&#10095;</button>
            </div>
            <div class="item-info">
                <h3><?=$item->name?></h3>
                <h4><?=$item->introduction?></h4>
                <p>Description: <?=$item->description?></p>
                <p>Brand: <?=$item->brand?></p>
                <p>Model: <?=$item->model?></p>
                <p>Price: $<?=$item->price?></p>             
                <p>Category: <?=Category::getCategoryById($db, $item->idCategory)->categoryName?></p>
                <p>Condition: <?=Condition::getConditionById($db, $item->idCondition)->conditionName?></p>
                <p>Size: <?=Size::getSizeById($db, $item->idSize)->sizeName?></p>
                <p>Seller: <a href="../pages/user-profile.php?idUser=<?=$item->idSeller?>"><?=User::getUserById($db, $item->idSeller)->name?></a></p>
                <p><span class="<?=$item->active ? 'active' : 'inactive'?>"><?=$item->active ? 'Active' : 'Inactive'?></span></p>
            </div>

            <!-- Formulário de Mensagem -->
            <div id="message-form">
                <h3>Contact Seller</h3>
                <form action="../utils/sendMessage.php" method="post">
                    <input type="hidden" name="recipient" value="<?=$item->idSeller?>">
                    <textarea name="message" rows="4" cols="50" placeholder="Enter your message here..."></textarea>
                    <input type="submit" value="Send Message">
                </form>
            </div>
        </article>  
    </section>
<?php } ?>
