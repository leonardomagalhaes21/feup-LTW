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
        </article>  
        <!-- Formulário de Mensagem -->
        <div id="message-form">
            <h3>Contact Seller</h3>
            <form action="../utils/sendMessage.php" method="post">
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
                Brand: <input type="text" id="brand" name="brand" required>
            </label><br>
            <label>
                Model: <input type="text" id="model" name="model" required>
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
