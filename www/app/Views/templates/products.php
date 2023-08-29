<h1 class="page-title">Products</h1>

<ul class="products-list">
    <?php foreach ($products as $product): ?>
        <li>
            <div class="products-list__product">
                <a class="products-list__img-link" href="/product/<?= $product['id'] ?>">
                    <img class="products-list__img"
                         src="/img/<?= $product['image_name'] ?>"
                         alt="">
                </a>

                <a class="products-list__title-link" href="/product/<?= $product['id'] ?>">
                    <h2 class="products-list__product-title">
                        <?= $product['title'] ?>
                    </h2>
                </a>

                <p class="products-list__product-price">£<?= $product['price'] ?></p>
            </div>
        </li>
    <?php endforeach; ?>
</ul>