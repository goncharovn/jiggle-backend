<ul class="products-list">
    <?php foreach ($products as $val): ?>
        <li>
            <div class="products-list__product">
                <a class="products-list__img-link" href="p/<?php echo $val['id']; ?>">
                    <img class="products-list__img"
                         src="/img/<?php echo $val['img_name']; ?>"
                         alt="">
                </a>

                <a class="products-list__title-link" href="p/<?php echo $val['id']; ?>">
                    <h2 class="products-list__product-title">
                        <?php echo $val['title']; ?>
                    </h2>
                </a>

                <p class="products-list__product-price">£<?php echo $val['price']; ?></p>
            </div>
        </li>
    <?php endforeach; ?>
</ul>