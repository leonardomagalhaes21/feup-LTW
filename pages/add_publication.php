<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/category.class.php');
require_once(__DIR__ . '/../database/item.class.php');
require_once(__DIR__ . '/../database/size.class.php');
require_once(__DIR__ . '/../database/condition.class.php');

require_once(__DIR__ . '/../templates/common.tpl.php');

$db = getDatabaseConnection();
drawHeader($session);

$categories = Category::getCategories($db);
$sizes = Size::getSizes($db);
$conditions = Condition::getConditions($db);

?>
<body>
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
                Price: <input type="number" id="price" name="price" required>
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
                Upload Main Image: <input type="file" id="main_image" name="main_image" required>
            </label><br>
            <label>
                Upload Secondary Images(max 5):<input type="file" id="secondary_images" name="secondary_images[]" multiple>
                <span class="hint"> (Select multiple images from file browser)</span>
            </label><br>
            <button type="submit">Submit</button>
        </form>
    </section>
</body>
</html>
