<div class="product">
    <div class="product__img-wrapper">
        <img src="/img/<?php echo $product[0]['img_name']; ?>" alt="">
    </div>

    <div class="product__details">
        <h2 class="product__title"><?php echo $product[0]['title']; ?></h2>
        <p class="product__price">£<?php echo $product[0]['price']; ?></p>

        <?php session_start();
        if (in_array($product[0]['id'], $_SESSION['basket'] ?? [])) : ?>
            <p>Product already in basket.</p>
        <?php else : ?>
            <form method="post" action="/add-to-basket/<?php echo $product[0]['id']; ?>">
                <input type="hidden" name="product__id" value="<?php echo $product[0]['id']; ?>">
                <button class="button product__add-button" type="submit">
                    Add to basket
                </button>
            </form>
        <?php endif; ?>
    </div>

    <div class="product__features">
        <h3>Product description</h3>
        <p class="text"><?php echo $product[0]['description']; ?></p>
    </div>
</div>