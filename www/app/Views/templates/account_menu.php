<nav class="account__menu">
    <ul class="account__menu-list">
        <li><a href="/my-account">Overview</a></li>
        <li><a href="/my-account/order-history">Order history</a></li>
        <li><a href="/my-account/delivery-address">Delivery addresses</a></li>
        <li><a href="/my-account/my-details">My details</a></li>
        <?php if ($isAdmin): ?>
            <li><a href="/admin/products">Admin</a></li>
        <?php endif; ?>
        <li>
            <form method="post" action="/sign-out">
                <button type="submit">Sign out</button>
            </form>
        </li>
    </ul>
</nav>