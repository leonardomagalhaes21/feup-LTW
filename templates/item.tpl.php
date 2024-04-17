<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/item.class.php')
?>

<?php function drawItems(array $items) { ?>
    <section id="items">
        <h2>Items for Sale</h2>
        <?php foreach ($items as $item) { ?>
            <article>
                <a href="../pages/item.php?idItem=<?=$item->idItem?>">
                    <img src="https://picsum.photos/200?theme=<?=$item->name?>" alt="<?=$item->name?>">
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

<?php function drawItem(Item $item) { ?>
    <section id="item-details">
        <header>
            <button>&#8592; Go Back</button>
            <h2>Item Overview</h2>
        </header>
        <article>
            <img src="https://picsum.photos/500/500?theme=<?=$item->name?>" alt="description">
            <div class="item-info">
                <h3><?=$item->name?></h3>
                <h4><?=$item->introduction?></h4>
                <p>Description: <?=$item->description?></p>
                <p>Brand: <?=$item->brand?></p>
                <p>Model: <?=$item->model?></p>
                <p>Price: $<?=$item->price?></p>
            </div>
        </article>
    </section>
<?php } ?>
