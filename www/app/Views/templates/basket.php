<h1 class="page-title">Basket</h1>

<?php if (empty($productsVariantsInBasket)) : ?>
    <div class="empty-basket">
        <h2 class="empty-basket__title">Your shopping basket is empty.</h2>
        <p class="empty-basket__subtitle">Looks like you haven't added anything yet.</p>
        <a class="button" href="/">Shop now</a>
    </div>
<?php else : ?>
    <div class="basket">
        <ul class="basket__list">
            <?php foreach ($productsVariantsInBasket as $productVariant): ?>
                <li>
                    <div class="basket__product">
                        <a
                                class="basket__img-link"
                                href="product/<?= $productVariant->getProductId(); ?>?color=<?= $productVariant->getColor() ?>&size=<?= $productVariant->getSize() ?>"
                        >
                            <img class="basket__img"
                                 src="/img/<?= $productVariant->getImageName(); ?>"
                                 alt=""
                            >
                        </a>

                        <div>
                            <a class="basket__title-link"
                               href="product/<?= $productVariant->getProductId(); ?>?color=<?= $productVariant->getColor() ?>&size=<?= $productVariant->getSize() ?>">
                                <h2 class="basket__title"><?= $productVariant->getTitle(); ?></h2>
                            </a>

                            <p class="basket__price">£<?= $productVariant->getPrice(); ?></p>
                        </div>

                        <form class="change-quantity" method="post" action="/change-product-variant-quantity-in-basket">
                            <input type="hidden" name="variant_id" value="<?= $productVariant->getVariantId() ?>">
                            <button class="change-quantity__button" type="submit" name="action" value="increase">
                                +
                            </button>
                            <span class="change-quantity__value"><?= $productVariant->getBasketQuantity(); ?></span>
                            <button class="change-quantity__button" type="submit" name="action" value="decrease">
                                -
                            </button>
                        </form>

                        <form class="basket__remove-form"
                              method="post"
                              action="/remove-product-variant-from-basket"
                        >
                            <input type="hidden" name="variant_id" value="<?= $productVariant->getVariantId(); ?>">
                            <button class="basket__remove" type="submit">Remove</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="basket__summary">
            <h2 class="basket__summary-title">Summary</h2>

            <div class="divider"></div>

            <div class="basket__order-total">
                <span>Order total</span>
                <span>£<?= $orderTotal; ?></span>
            </div>
        </div>
    </div>
<?php endif; ?>