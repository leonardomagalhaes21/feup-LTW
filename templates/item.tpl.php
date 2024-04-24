<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/item.class.php')
?>

<?php function drawItems(array $items, PDO $db, bool $drawHeader, bool $isCartPage = false, bool $isInWishlistPage = false) { ?>

<section id="items">
    <?php if ($drawHeader){ ?>
    <h2>Items in <?php echo $isCartPage ? 'Cart' : ($isInWishlistPage ? 'Wishlist' : 'Sale'); ?></h2>
    <?php } ?>
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
                <h3>
                    <?php if (!empty($item->brand) && !empty($item->model)) {
                        echo "{$item->brand} - {$item->model}";
                    } 
                    elseif (!empty($item->brand)) {
                        echo $item->brand;
                    } 
                    elseif (!empty($item->model)) {
                        echo $item->model;
                    }
                    ?>
                </h3>
                <p>Price: $<?=$item->price?></p>
                <?php if ($isCartPage) { ?>
                    <form action="../actions/action_remove_from_cart.php" method="post">
                        <input type="hidden" name="idItem" value="<?=$item->idItem?>">
                        <button type="submit">Remove from Cart</button>
                    </form>
                <?php } elseif ($isInWishlistPage) { ?>
                    <form action="../actions/action_remove_from_wishlist.php" method="post">
                        <input type="hidden" name="idItem" value="<?=$item->idItem?>">
                        <button type="submit">Remove from Wishlist</button>
                    </form>
                <?php } else { ?>
                    <form action="../actions/action_add_to_cart.php" method="post">
                        <input type="hidden" name="idItem" value="<?=$item->idItem?>">
                        <button type="submit">Add to Cart</button>
                    </form>
                <?php } ?>
            </div>
        </article>
    <?php } ?>
</section>
<?php } ?>


<?php function drawItem(PDO $db, Item $item, bool $isAdmin = false, bool $isInWishlist = false) { ?>
    <section id="item-details">
        <header>
            <button>&#8592; Go Back</button>
            <h2>Item Overview</h2>
            <?php if ($isAdmin) { ?>
                <form action="../actions/action_item_change_featured.php" method="post">
                    <input type="hidden" name="idItem" value="<?=$item->idItem?>">
                    <button type="submit"><?=($item->featured ? 'Remove from Featured' : 'Set as Featured')?></button>
                </form>
            <?php } ?>
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
                <p><?=$item->description?></p>
                <p>Brand: <?=$item->brand?></p>
                <p>Model: <?=$item->model?></p>
                <p>Price: $<?=$item->price?></p>             
                <p>Category: <?=Category::getCategoryById($db, $item->idCategory)->categoryName?></p>
                <p>Condition: <?=Condition::getConditionById($db, $item->idCondition)->conditionName?></p>
                <p>Size: <?=Size::getSizeById($db, $item->idSize)->sizeName?></p>
                <p>Seller: <a href="../pages/user-profile.php?idUser=<?=$item->idSeller?>"><?=User::getUserById($db, $item->idSeller)->name?></a></p>
                <p><span class="<?=$item->active ? 'active' : 'inactive'?>"><?=$item->active ? 'Active' : 'Inactive'?></span></p>
            </div>
            <?php if (!$isInWishlist) { ?>
            <form action="../actions/action_add_to_wishlist.php" method="post">
                <input type="hidden" name="idItem" value="<?=$item->idItem?>">
                <button type="submit">Add to Wishlist</button>
            </form>
            <?php } else { ?>
            <form action="../actions/action_remove_from_wishlist.php" method="post">
                <input type="hidden" name="idItem" value="<?=$item->idItem?>">
                <button type="submit">Remove from Wishlist</button>
            </form>
            <?php } ?>
            
            <form action="../pages/chat_messages.php" method="get">
                <input type="hidden" name="otherUserId" value="<?=$item->idSeller?>">
                <input type="hidden" name="itemId" value="<?=$item->idItem?>">
                <button type="submit" class="chat-button">Chat with Seller</button>
            </form>

        </article>  
        <div id="message-form">
            <h3>Contact Seller</h3>
            <form action="../actions/action_send_message.php" method="post">
                <input type="hidden" name="recipient" value="<?=$item->idSeller?>">
                <textarea name="message" rows="4" cols="50" placeholder="Enter your message here..."></textarea>
                <input type="submit" value="Send Message">
            </form>
        </div>
    </section>
<?php } ?>


<?php function drawAddPublication(array $categories, array $sizes, array $conditions) { ?>
    <?php
        if (isset($_SESSION['message'])) {
            echo "<p>{$_SESSION['message']}</p>";
            unset($_SESSION['message']);
        }
    ?>
    <section id = "add-publication">
        <h1>Add New Publication</h1>
        <form action="../actions/action_add_publication.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            <label>
                Name: <input type="text" id="name" name="name" required>
            </label><br>
            <label>
                Description: <input type="text" id="description" name="description" required>
            </label><br>
            <label>
                Introduction: <input type="text" id="introduction" name="introduction" required>
            </label><br>
            <label>
                Brand: <input type="text" id="brand" name="brand">
            </label><br>
            <label>
                Model: <input type="text" id="model" name="model">
            </label><br>
            <label>
                Price: <input type="number" id="price" name="price" step="0.01" required>
            </label><br>
            <label>
                Category:
                <select id="idCategory" name="idCategory" required>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?php echo $category->idCategory; ?>"><?php echo $category->categoryName; ?></option>
                    <?php } ?>
                </select>
            </label><br>
            <label>
                Condition:
                <select id="idCondition" name="idCondition" required>
                    <?php foreach ($conditions as $condition) { ?>
                        <option value="<?php echo $condition->idCondition; ?>"><?php echo $condition->conditionName; ?></option>
                    <?php } ?>
                </select>
            </label><br>
            <label>
                Size:
                <select id="idSize" name="idSize" required>
                    <?php foreach ($sizes as $size) { ?>
                        <option value="<?php echo $size->idSize; ?>"><?php echo $size->sizeName; ?></option>
                    <?php } ?>
                </select>
            </label><br>
            <label>
                Upload Main Image: <input type="file" id="main_image" name="main_image" required onchange="previewMainImage(event)">
            </label>
            <img id="main_image_preview" src="#" alt="Main Image Preview">
            <label>
                Upload Secondary Images(max 5):<input type="file" id="secondary_images" name="secondary_images[]" multiple onchange="previewSecondaryImages(event)">
                <span class="hint"> (Select multiple images from file browser)</span>
            </label>

            <div id="secondary_images_preview"></div>
            <button type="submit">Submit</button>
        </form>
    </section>
<?php } ?>


