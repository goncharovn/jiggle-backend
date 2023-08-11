<div class="product">
    <div class="product__img-wrapper">
        <img src="/img/<?= $product['img_name']; ?>" alt="">
    </div>

    <div class="product__details">
        <h2 class="product__title"><?= $product['title']; ?></h2>
        <p class="product__price">£<?= $product['price']; ?></p>

        <?php if ($quantityOfProductInStock > 0) : ?>
            <?php if ($isProductInBasket) : ?>
                <form class="change-quantity product__change-quantity" method="post" action="/p/change-quantity">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button class="change-quantity__button" type="submit" name="action" value="increase">
                        +
                    </button>
                    <span class="change-quantity__value"><?= $quantityOfProductInBasket; ?></span>
                    <button class="change-quantity__button" type="submit" name="action" value="decrease">
                        -
                    </button>
                </form>

                <p><?= $quantityOfProductInBasket; ?> <?= $message; ?> in your <a href="/basket">basket</a>.</p>

                <p><?= $errorMessage ?></p>
            <?php else : ?>
                <form method="post" action="/p/change-quantity">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button class="button product__add-button" type="submit" name="action" value="increase">
                        Add to basket
                    </button>
                </form>
            <?php endif; ?>
        <?php else : ?>
            <p>The product is out of stock.</p>
        <?php endif; ?>
    </div>

    <div class="product__features">
        <h3>Product description</h3>
        <p class="text"><?= $product['description']; ?></p>
    </div>
</div>