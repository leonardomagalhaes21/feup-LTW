<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/item.class.php')
?>

<?php function drawItems(array $items, PDO $db, bool $drawHeader, bool $isCartPage = false, bool $isInWishlistPage = false) { ?>

<section id="items">
    <?php if ($drawHeader){ ?>
    <h2>Items <?php echo $isCartPage ? 'Cart' : ($isInWishlistPage ? 'in Wishlist' : 'for Sale'); ?></h2>
    <?php } ?>
    <?php foreach ($items as $item) { ?>
        <article>
            <?php $mainImagePath = htmlentities($item->getMainImage($db)); ?>
            <a href="../pages/item.php?idItem=<?=$item->idItem?>">
                <img src="<?=$mainImagePath?>" alt="<?=htmlentities($item->name)?>">
            </a>
            <div class="item-details">
                <h2>
                    <a href="../pages/item.php?idItem=<?=$item->idItem?>"><?=htmlentities($item->name)?></a>
                </h2>
                <h3>
                    <?php if (!empty($item->brand) && !empty($item->model)) {
                        echo htmlentities("{$item->brand} - {$item->model}");
                    } 
                    elseif (!empty($item->brand)) {
                        echo htmlentities($item->brand);
                    } 
                    elseif (!empty($item->model)) {
                        echo htmlentities($item->model);
                    }
                    ?>
                </h3>
                <p>Price: $<?=htmlentities((string)$item->price)?></p>
                <?php $isFromUser = isset($_SESSION['id']) && (int) $item->idSeller === (int) $_SESSION['id']; ?>
                <?php if (!$isFromUser && isset($_SESSION['id'])) { ?>
                    <?php if ($isCartPage || (!$isInWishlistPage && (isset($_SESSION['cart']) && in_array($item->idItem, $_SESSION['cart'])))) { ?>
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
                <?php } ?>
            </div>
        </article>
    <?php } ?>
</section>
<?php } ?>



<?php function drawItem(PDO $db, Item $item, bool $isAdmin = false, bool $isInWishlist = false, bool $isFromUser = false) { ?>
    <section id="item-details">
        <header>
            <button onclick="goBack()">&#8592; Go Back</button>
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
            $mainImagePath = htmlentities($item->getMainImage($db));
            $secondaryImages = $item->getSecondaryImages($db);
            ?>
            <div class="slideshow">
                <?php 
                echo '<div class="image-slide"><img src="' . $mainImagePath . '" alt="' . htmlentities($item->name) . '"></div>';
    
                foreach ($secondaryImages as $image) {
                    echo '<div class="image-slide"><img src="' . htmlentities($image['imagePath']) . '" alt="' . htmlentities($item->name) . '"></div>';
                }
                ?>
                <button onclick="plusSlides(-1)">&#10094;</button>
                <button onclick="plusSlides(1)">&#10095;</button>
            </div>
            <div class="item-info">
                <h3><?=htmlentities($item->name)?></h3>
                <h4><?=htmlentities($item->introduction)?></h4>
                <p><?=htmlentities($item->description)?></p>
                <p>Brand: <?=htmlentities($item->brand)?></p>
                <p>Model: <?=htmlentities($item->model)?></p>
                <p>Price: $<?=htmlentities((string)$item->price)?></p>             
                <p>Category: <?=htmlspecialchars_decode(htmlentities(Category::getCategoryById($db, $item->idCategory)->categoryName))?></p>
                <p>Condition: <?=htmlentities(Condition::getConditionById($db, $item->idCondition)->conditionName)?></p>
                <p>Size: <?=htmlentities(Size::getSizeById($db, $item->idSize)->sizeName)?></p>
                <p>Seller: <a href="../pages/user-profile.php?idUser=<?=$item->idSeller?>"><?=htmlentities(User::getUserById($db, $item->idSeller)->name)?></a></p>
                <p><span class="<?=htmlentities($item->active ? 'active' : 'inactive')?>"><?=htmlentities($item->active ? 'Active' : 'Inactive')?></span></p>
            </div>
        </article>
        <?php if (!$isFromUser && isset($_SESSION['id']) && $item->active) { ?>
            <div class="buttons">
                <form action="<?php echo $isInWishlist ? '../actions/action_remove_from_wishlist.php' : '../actions/action_add_to_wishlist.php'; ?>" method="post">
                    <input type="hidden" name="idItem" value="<?php echo $item->idItem; ?>">
                    <button type="submit">
                        <?php echo $isInWishlist ? 'Remove from Wishlist' : 'Add to Wishlist'; ?>
                    </button>
                </form>   
                <form action="../pages/chat_messages.php" method="get">
                    <input type="hidden" name="otherUserId" value="<?=$item->idSeller?>">
                    <input type="hidden" name="itemId" value="<?=$item->idItem?>">
                    <button type="submit" class="chat-button">Chat with Seller</button>
                </form>
                <?php if(!isset($_SESSION['cart']) || !in_array($item->idItem, $_SESSION['cart'])) { ?>
                <form action="../actions/action_add_to_cart.php" method="post">
                    <input type="hidden" name="idItem" value="<?=$item->idItem?>">
                    <button type="submit">Add to Cart</button>
                </form>
                <?php } else { ?>
                <form action="../actions/action_remove_from_cart.php" method="post">
                    <input type="hidden" name="idItem" value="<?=$item->idItem?>">
                    <button type="submit">Remove from Cart</button>
                </form>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if($isAdmin && (isset($_SESSION['id']) && $_SESSION['id'] != $item->idSeller)){?>
                <div class="buttons">
                    <form action="../pages/edit_item.php" method="get">
                        <input type="hidden" name="idItem" value="<?=$item->idItem?>">
                        <button type="submit">Edit Item</button>
                    </form>
                    <form action="../actions/action_remove_item.php" method="post">
                        <input type="hidden" name="idItem" value="<?=$item->idItem?>">
                        <button type="submit">Remove Item</button>
                    </form>
                </div>
        <?php }?>
        <?php if (isset($_SESSION['id']) && $_SESSION['id'] == $item->idSeller) { ?>
            <div class="buttons">
                <form action="../pages/edit_item.php" method="get">
                    <input type="hidden" name="idItem" value="<?=$item->idItem?>">
                    <button type="submit">Edit Item</button>
                </form>
                <form action="../actions/action_remove_item.php" method="post">
                    <input type="hidden" name="idItem" value="<?=$item->idItem?>">
                    <button type="submit">Remove Item</button>
                </form>
            </div>
        <?php } ?>
    </section>
<?php } ?>


<?php function drawAddPublication(array $categories, array $sizes, array $conditions) { ?>
    <?php
        if (isset($_SESSION['message'])) {
            echo "<p>".htmlentities($_SESSION['message'])."</p>";
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
                        <option value="<?php echo $category->idCategory; ?>"><?php echo htmlspecialchars_decode(htmlentities($category->categoryName)); ?></option>
                    <?php } ?>
                </select>
            </label><br>
            <label>
                Condition:
                <select id="idCondition" name="idCondition" required>
                    <?php foreach ($conditions as $condition) { ?>
                        <option value="<?php echo $condition->idCondition; ?>"><?php echo htmlentities($condition->conditionName); ?></option>
                    <?php } ?>
                </select>
            </label><br>
            <label>
                Size:
                <select id="idSize" name="idSize" required>
                    <?php foreach ($sizes as $size) { ?>
                        <option value="<?php echo $size->idSize; ?>"><?php echo htmlentities($size->sizeName); ?></option>
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


