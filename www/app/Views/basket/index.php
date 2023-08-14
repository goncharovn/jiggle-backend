<?php if (empty($productsInBasket)) : ?>
    <div class="empty-basket">
        <h2 class="empty-basket__title">Your shopping basket is empty.</h2>
        <p class="empty-basket__subtitle">Looks like you haven't added anything yet.</p>
        <a class="button" href="/">Shop now</a>
    </div>
<?php else : ?>
    <div class="basket">
        <ul class="basket__list">
            <?php foreach ($productsInBasket as $product): ?>
                <li>
                    <div class="basket__product">
                        <a
                                class="basket__img-link"
                                href="p/<?= $product['id']; ?>?color=<?= $product['color'] ?>&size=<?= $product['size'] ?>"
                        >
                            <img class="basket__img"
                                 src="/img/<?= $product['image_name']; ?>"
                                 alt=""
                            >
                        </a>

                        <div>
                            <a class="basket__title-link"
                               href="p/<?= $product['id']; ?>?color=<?= $product['color'] ?>&size=<?= $product['size'] ?>">
                                <h2 class="basket__title"><?= $product['title']; ?></h2>
                            </a>

                            <p class="basket__price">£<?= $product['price']; ?></p>
                        </div>

                        <form class="change-quantity" method="post" action="">
                            <input type="hidden" name="product_color" value="<?= $product['color'] ?>">
                            <input type="hidden" name="product_size" value="<?= $product['size'] ?>">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <button class="change-quantity__button" type="submit" name="action" value="increase">
                                +
                            </button>
                            <span class="change-quantity__value"><?= $product['quantity']; ?></span>
                            <button class="change-quantity__button" type="submit" name="action" value="decrease">
                                -
                            </button>
                        </form>

                        <form class="basket__remove-form"
                              method="post"
                              action="/remove-product"
                        >
                            <input type="hidden" name="variant_id" value="<?= $product['variant_id']; ?>">
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