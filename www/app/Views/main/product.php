<div class="product">
    <div class="product__img-wrapper">
        <img  src="/img/<?php echo $product[0]['img_name']; ?>" alt="">
    </div>
    <div class="product__details">
        <h2 class="product__title"><?php echo $product[0]['title']; ?></h2>
        <p class="product__price">£<?php echo $product[0]['price']; ?></p>
        <button class="button">
            Add to basket
        </button>
    </div>
</div>