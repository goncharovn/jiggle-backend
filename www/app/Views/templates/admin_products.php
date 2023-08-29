<header class="admin__header">
    <h1 class="admin__main-heading">Products</h1>
</header>
<main class="admin__main">
    <div class="admin-products__top">
        <input class="admin-search admin-products__search" type="search" placeholder="Search products">
        <a class="admin-button" href="/admin/add-product">
            <img src="/img/plus.svg" alt="">
            <span>add product</span>
        </a>
    </div>

    <nav class="admin-products__menu">
        <ul class="admin-products__menu-list">
            <li class="admin-products__menu-item">Cycle <img width="16" height="16" src="/img/arrow.svg" alt=""></li>
            <li class="admin-products__menu-item">Run <img width="16" height="16" src="/img/arrow.svg" alt=""></li>
            <li class="admin-products__menu-item">Swim & Water Sports <img width="16" height="16" src="/img/arrow.svg"
                                                                           alt=""></li>
            <li class="admin-products__menu-item">Triathlon <img width="16" height="16" src="/img/arrow.svg" alt="">
            </li>
            <li class="admin-products__menu-item">Gym <img width="16" height="16" src="/img/arrow.svg" alt=""></li>
            <li class="admin-products__menu-item">Outdoors <img width="16" height="16" src="/img/arrow.svg" alt=""></li>
            <li class="admin-products__menu-item">Nutrition & Body Care <img width="16" height="16" src="/img/arrow.svg"
                                                                             alt=""></li>
            <li class="admin-products__menu-item">Tech <img width="16" height="16" src="/img/arrow.svg" alt=""></li>
        </ul>
    </nav>

    <div class="admin-products__sort-row">
        <h2 class="admin-products__chosen-category">Run</h2>
        <div class="sort admin-products__sort">Sort: Price High To Low</div>
    </div>

    <div class="admin-products__results">
        <div class="admin-filters">
            <div class="admin-filters__item">
                <h3 class="admin-filters__heading">Brand name</h3>

                <div class="admin-filters__variants">
                    <label class="admin-filters__label"><input type="checkbox" name="brand">HOKA ONE ONE</label>
                    <label class="admin-filters__label"><input type="checkbox" name="brand">Nike</label>
                    <label class="admin-filters__label"><input type="checkbox" name="brand">Adidas</label>
                </div>
            </div>
            <div class="admin-filters__item">
                <h3 class="admin-filters__heading">Price</h3>

                <div class="admin-filters__variants">
                    <label class="admin-filters__label"><input type="checkbox" name="price">£0-£5</label>
                    <label class="admin-filters__label"><input type="checkbox" name="price">£10-£20</label>
                    <label class="admin-filters__label"><input type="checkbox" name="price">£20-£30</label>
                    <label class="admin-filters__label"><input type="checkbox" name="price">£30-£50</label>
                    <label class="admin-filters__label"><input type="checkbox" name="price">£50-£100</label>
                    <label class="admin-filters__label"><input type="checkbox" name="price">£100-£300</label>
                    <label class="admin-filters__label"><input type="checkbox" name="price">£300-£600</label>
                    <label class="admin-filters__label"><input type="checkbox" name="price">£600-£1000</label>
                    <label class="admin-filters__label"><input type="checkbox" name="price">£1000-£2500</label>
                    <label class="admin-filters__label"><input type="checkbox" name="price">£2500-£5000</label>
                    <label class="admin-filters__label"><input type="checkbox" name="price">£5000 +</label>
                </div>
            </div>
        </div>

        <table class="admin-table admin-products__table">
            <thead class="admin-table__row admin-table__head-row">
            <th class="admin-table__cell">Title</th>
            <th class="admin-table__cell">Brand</th>
            <th class="admin-table__cell">Price</th>
            <th class="admin-table__cell">Category</th>
            <th class="admin-table__cell">Subcategory 1</th>
            <th class="admin-table__cell">Subcategory 2</th>
            <th class="admin-table__cell"></th>
            </thead>

            <tr class="admin-table__row">
                <td class="admin-table__cell">Hoka One One Mach</td>
                <td class="admin-table__cell">HOKA ONE ONE</td>
                <td class="admin-table__cell">£160</td>
                <td class="admin-table__cell">Run</td>
                <td class="admin-table__cell">Running shoes</td>
                <td class="admin-table__cell">Road running shoes</td>
                <td class="admin-table__cell"><a href="/admin/edit-product"><img src="/img/pencil.svg" alt=""></a></td>
            </tr>
        </table>
    </div>
</main>