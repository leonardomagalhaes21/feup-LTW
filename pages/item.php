<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/category.class.php');
    require_once(__DIR__ . '/../database/item.class.php');

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/item.tpl.php');

    $db = getDatabaseConnection();
    $idItem =(int) $_GET['idItem'];

    $categories = Category::getCategories($db);
    $item = Item::getItemById($db, $idItem);

    drawHeader($session);
    drawCategories($categories);
    drawItem($db, $item);
    drawFooter();
    //corrijir este js e meter no sitio certo
    ?>
<script>

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function showSlides(n) {
        let slides = document.getElementsByClassName("image-slide");

        if (n > slides.length) {slideIndex = 1}    
        if (n < 1) {slideIndex = slides.length}
        
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        slides[slideIndex-1].style.display = "block";  
    }

    let slideIndex = 1;
    showSlides(slideIndex);

</script>


