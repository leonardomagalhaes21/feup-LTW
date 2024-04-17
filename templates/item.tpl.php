<?php 
  declare(strict_types = 1); 
?>

<?php function drawItems(array $items) { ?>
    <section id="items">
        <h2>Items for Sale</h2>
        <?php foreach ($items as $item) { ?>
            <article>
                <a href="../pages/item.php">
                    <img src="https://picsum.photos/200?theme=<?=$item->name?>" alt="<?=$item->name?>">
                </a>
                <div class="item-details">
                    <h2>
                        <a href="../pages/item.php"><?=$item->name?></a>
                    </h2>
                    <p><?=$item->description?></p>
                    <p>Price: <?=$item->price?></p>
                </div>
            </article>
        <?php } ?>
    </section>
<?php } ?>
