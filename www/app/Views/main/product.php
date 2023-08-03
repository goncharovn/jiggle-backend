<div class="product">
    <div class="product__img-wrapper">
        <img src="/img/<?php echo $product['img_name']; ?>" alt="">
    </div>

    <div class="product__details">
        <h2 class="product__title"><?php echo $product['title']; ?></h2>
        <p class="product__price">£<?php echo $product['price']; ?></p>

        <?php if ($isProductInBasket) : ?>
            <p>Product already in basket.</p>
        <?php else : ?>
            <form method="post" action="/add-to-basket/<?php echo $product['id']; ?>">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                <button class="button product__add-button" type="submit">
                    Add to basket
                </button>
            </form>
        <?php endif; ?>
    </div>

    <div class="product__features">
        <h3>Product description</h3>
        <p class="text"><?php echo $product['description']; ?></p>
    </div>
</div>