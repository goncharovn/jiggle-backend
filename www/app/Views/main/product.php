<div class="product">
    <div class="product__img-wrapper">
        <img src="/img/<?= $product['image_name']; ?>" alt="">
    </div>

    <div class="product__details">
        <h1 class="product__title"><?= $product['title']; ?></h1>
        <div class="product__color">Color: <?= $product['color']; ?></div>
        <form method="get" action="">
            <div class="product__colors">
                <?php foreach ($availableColors as $color): ?>
                    <a
                        <?php if ($color['name'] === $product['color']): ?>
                            class="select-color-button select-color-button_selected"
                        <?php else: ?>
                            class="select-color-button"
                        <?php endif; ?>
                            href="?color=<?= $color['name'] ?><?php if ($product['size']) {
                                echo '&size=' . $product['size'];
                            } ?>"
                    >
                        <div
                                class="select-color-button__color"
                                style="background-image: linear-gradient(#<?= $color['value']; ?>, #<?= $color['value']; ?>)"
                        >

                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="product__sizes">
                <?php foreach ($availableSizes as $size): ?>
                    <a
                        <?php if ($size['name'] === $product['size']): ?>
                            class="select-size-button select-size-button_selected"
                        <?php else: ?>
                            class="select-size-button"
                        <?php endif; ?>
                            href="?color=<?= $product['color']; ?>&size=<?= $size['name']; ?>"
                    >
                        <?= $size['name']; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </form>

        <?php if ($unselectedSizeError): ?>
            <div class="product__size-error"><?= $unselectedSizeError ?></div>
        <?php endif; ?>

        <p class="product__price">£<?= $product['price']; ?></p>

        <?php if ($quantityOfProductInStock > 0) : ?>
            <?php if ($isProductInBasket) : ?>
                <form class="change-quantity product__change-quantity" method="post" action="">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="hidden" name="product_color" value="<?= $product['color'] ?>">
                    <input type="hidden" name="product_size" value="<?= $product['size'] ?>">
                    <button class="change-quantity__button" type="submit" name="action" value="increase">
                        +
                    </button>
                    <span class="change-quantity__value"><?= $quantityOfProductInBasket; ?></span>
                    <button class="change-quantity__button" type="submit" name="action" value="decrease">
                        -
                    </button>
                </form>

                <p><?= $quantityOfProductInBasket; ?> <?= $message; ?> in your <a href="/basket">basket</a>.</p>

                <p><?= $quantityLimitError ?></p>
            <?php else : ?>
                <form method="post" action="">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="hidden" name="product_color" value="<?= $product['color'] ?>">
                    <input type="hidden" name="product_size" value="<?= $product['size'] ?>">
                    <button class="button product__add-button" type="submit" name="action" value="increase">
                        Add to basket
                    </button>
                </form>
            <?php endif; ?>
        <?php else : ?>
            <p>Out of stock.</p>
        <?php endif; ?>
    </div>

    <div class="product__features">
        <h3>Product description</h3>
        <p class="text"><?= $product['description']; ?></p>
    </div>
</div>