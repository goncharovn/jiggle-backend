<?php
/**
 * @var ProductModel $product
 * @var array $availableColors
 * @var array $availableSizes
 * @var int $quantityOfProductInBasket
 * @var int $quantityOfProductInStock
 * @var string $unselectedSizeError
 * @var string $quantityLimitError
 * @var string $message
 * @var bool $isProductInBasket
 */

use jiggle\app\Models\ProductModel;

?>

<div class="product">
    <div class="product__img-wrapper">
        <img src="/img/<?= $product->getImageName() ?>" alt="">
    </div>

    <section class="product__details">
        <h1 class="product__title"><?= $product->getTitle() ?></h1>
        <div class="product__color">Color: <?= $product->getColor() ?></div>
        <form method="get" action="">
            <div class="product__colors">
                <?php foreach ($availableColors as $color): ?>
                    <a
                        <?php if ($color['name'] === $product->getColor()): ?>
                            class="select-color-button select-color-button_selected"
                        <?php else: ?>
                            class="select-color-button"
                        <?php endif; ?>
                            href="?color=<?= $color['name'] ?><?php if ($product->getSize()) {
                                echo '&size=' . $product->getSize();
                            } ?>"
                    >
                        <div
                                class="select-color-button__color"
                                style="background-image: linear-gradient(#<?= $color['value'] ?>, #<?= $color['value'] ?>)"
                        >

                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="product__sizes">
                <?php foreach ($availableSizes as $size): ?>
                    <a
                        <?php if ($size['name'] === $product->getSize()): ?>
                            class="select-size-button select-size-button_selected"
                        <?php else: ?>
                            class="select-size-button"
                        <?php endif; ?>
                            href="?color=<?= $product->getColor() ?>&size=<?= $size['name'] ?>"
                    >
                        <?= $size['name'] ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </form>

        <?php if ($unselectedSizeError): ?>
            <div class="product__size-error"><?= $unselectedSizeError ?></div>
        <?php endif; ?>

        <p class="product__price">£<?= $product->getPrice() ?></p>

        <?php if ($quantityOfProductInStock > 0) : ?>
            <?php if ($isProductInBasket) : ?>
                <form class="change-quantity product__change-quantity" method="post" action="/change-product-variant-quantity-in-basket">
                    <input type="hidden" name="product_id" value="<?= $product->getProductId() ?>">
                    <input type="hidden" name="variant_id" value="<?= $product->getVariantId() ?>">
                    <input type="hidden" name="product_color" value="<?= $product->getColor() ?>">
                    <input type="hidden" name="product_size" value="<?= $product->getSize() ?>">
                    <button class="change-quantity__button" type="submit" name="action" value="increase">
                        +
                    </button>
                    <span class="change-quantity__value"><?= $quantityOfProductInBasket ?></span>
                    <button class="change-quantity__button" type="submit" name="action" value="decrease">
                        -
                    </button>
                </form>

                <p><?= $quantityOfProductInBasket ?> <?= $message ?> in your <a href="/basket">basket</a>.</p>

                <p><?= $quantityLimitError ?></p>
            <?php else : ?>
                <form method="post" action="/change-product-variant-quantity-in-basket">
                    <input type="hidden" name="product_id" value="<?= $product->getProductId() ?>">
                    <input type="hidden" name="variant_id" value="<?= $product->getVariantId() ?>">
                    <input type="hidden" name="product_color" value="<?= $product->getColor() ?>">
                    <input type="hidden" name="product_size" value="<?= $product->getSize() ?>">
                    <button class="button product__add-button" type="submit" name="action" value="increase">
                        Add to basket
                    </button>
                </form>
            <?php endif; ?>
        <?php else : ?>
            <p>Out of stock.</p>
        <?php endif; ?>
    </section>

    <section class="product__features">
        <h3>Product description</h3>
        <p class="text"><?= $product->getDescription() ?></p>
    </section>
</div>