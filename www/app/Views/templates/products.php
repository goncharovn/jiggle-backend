<h1 class="page-title">Products</h1>

<ul class="products-list">
    <?php foreach ($products as $product): ?>
        <li>
            <div class="products-list__product">
                <a class="products-list__img-link" href="/product/<?= $product->getId() ?>">
                    <img class="products-list__img"
                         src="/img/<?= $product->getImageName() ?>"
                         alt="">
                </a>

                <a class="products-list__title-link" href="/product/<?= $product->getId() ?>">
                    <h2 class="products-list__product-title">
                        <?= $product->getTitle() ?>
                    </h2>
                </a>

                <p class="products-list__product-price">£<?= $product->getPrice() ?></p>
            </div>
        </li>
    <?php endforeach; ?>
</ul>