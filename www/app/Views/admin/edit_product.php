<header class="admin__header">
    <h1 class="admin__main-heading">Edit product</h1>
</header>
<main class="admin__main add-product">
    <div>
        <div>Title</div>
        <input type="text">
    </div>
    <div>
        <div>Price</div>
        <input type="text">
    </div>
    <div>
        <div>Description</div>
        <textarea name="" id="" cols="30" rows="10"></textarea>
    </div>
    <div>
        <div>Brand</div>
        <select name="" id="">
            <option value="Nike">Nike</option>
            <option value="HOKA ONE ONE">HOKA ONE ONE</option>
            <option value="Adidas">Adidas</option>
        </select>
        <button class="admin-button">
            <img src="/img/plus.svg" alt="">
            <span>add</span>
        </button>
    </div>
    <div>
        <div>Category</div>
        <select name="" id="">
            <option value="Run">Run</option>
            <option value="Cycle">Cycle</option>
        </select>
        <button class="admin-button">
            <img src="/img/plus.svg" alt="">
            <span>add</span>
        </button>
    </div>
    <div>
        <div>Subcategory 1</div>
        <select name="" id="">
            <option value="Bikes">Bikes</option>
            <option value="Bike parts">Bike parts</option>
        </select>
        <button class="admin-button">
            <img src="/img/plus.svg" alt="">
            <span>add</span>
        </button>
    </div>
    <div>
        <div>Subcategory 2</div>
        <select name="" id="">
            <option value="Road bikes">Road bikes</option>
            <option value="Gravel bikes">Gravel bikes</option>
        </select>
        <button class="admin-button">
            <img src="/img/plus.svg" alt="">
            <span>add</span>
        </button>
    </div>
    <div>
        <div>Color</div>
        <select name="" id="">
            <option value="Yellow">Yellow</option>
            <option value="Black">Black</option>
        </select>
        <button class="admin-button">
            <img src="/img/plus.svg" alt="">
            <span>add</span>
        </button>
    </div>
    <div>
        <div>Sizes</div>
        <label><input type="checkbox" name="size">XS</label>
        <label><input type="checkbox" name="size">S</label>
        <label><input type="checkbox" name="size">M</label>
        <label><input type="checkbox" name="size">L</label>
        <label><input type="checkbox" name="size">XL</label>
        <label><input type="checkbox" name="size">XXL</label>
        <button class="admin-button">
            <img src="/img/plus.svg" alt="">
            <span>add</span>
        </button>
    </div>
    <div>
        <div>Stock</div>
        <input type="number">
    </div>
    <div>
        <div>Image</div>
        <input type="file">
    </div>
    <div>
        <div>Gender</div>
        <select name="" id="">
            <option value="All">All</option>
            <option value="Man">Man</option>
            <option value="Woman">Woman</option>
        </select>
    </div>

    <table class="admin-table">
        <h3>Product variants</h3>
        <thead class="admin-table__row admin-table__head-row">
        <th class="admin-table__cell">SKU</th>
        <th class="admin-table__cell">Image</th>
        <th class="admin-table__cell">Color</th>
        <th class="admin-table__cell">Size</th>
        <th class="admin-table__cell">Stock</th>
        <th class="admin-table__cell">Gender</th>
        <th class="admin-table__cell"></th>
        </thead>

        <tr class="admin-table__row">
            <td class="admin-table__cell">1</td>
            <td class="admin-table__cell"><img src="" alt=""></td>
            <td class="admin-table__cell">Green</td>
            <td class="admin-table__cell">UK 10</td>
            <td class="admin-table__cell">50</td>
            <td class="admin-table__cell">All</td>
            <td class="admin-table__cell"><a href="/admin/edit-product-variant"><img src="/img/pencil.svg" alt=""></a></td>
        </tr>
    </table>
</main>