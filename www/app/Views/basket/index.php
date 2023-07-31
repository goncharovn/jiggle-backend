<?php if (empty($basketData)) : ?>
    <div class="empty-basket">
        <h2 class="empty-basket__title">Your shopping basket is empty.</h2>
        <p class="empty-basket__subtitle">Looks like you haven't added anything yet.</p>
<!--        <p class="empty-basket__subtitle">If you are a registered user sign in to retrieve any saved items.</p>-->
        <a class="button" href="/">Shop now</a>
    </div>
<?php else : ?>
    <div class="basket">
        <ul class="basket__list">
            <?php foreach ($basketData as $val): ?>
                <li>
                    <div class="basket__product">
                        <a class="basket__img-link" href="p/<?php echo $val['id']; ?>">
                            <img class="basket__img"
                                 src="/img/<?php echo $val['img_name']; ?>"
                                 alt="">
                        </a>

                        <div>
                            <a class="basket__title-link" href="p/<?php echo $val['id']; ?>">
                                <h2 class="basket__title"><?php echo $val['title']; ?></h2>
                            </a>

                            <p class="basket__price">£<?php echo $val['price']; ?></p>
                        </div>

                        <form class="basket__remove-form" method="post" action="/remove-from-basket/<?php echo $val['id']; ?>">
                            <input type="hidden" name="product__id" value="<?php echo $val['id']; ?>">
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
                <span>£10</span>
            </div>
        </div>
    </div>
<?php endif; ?>