<div class="account">
    <nav class="account__menu">
        <ul class="account__menu-list">
            <li><a href="/my-account">Overview</a></li>
            <li><a href="/my-account/order-history">Order history</a></li>
            <li><a href="/my-account/delivery-address">Delivery addresses</a></li>
            <li><a href="/my-account/my-details">My details</a></li>
            <li>
                <form method="post" action="/signout">
                    <button type="submit">Sign out</button>
                </form>
            </li>
        </ul>
    </nav>

    <div class="account__info">
        <header class="account__header">
            <h1 class="account__heading">My details</h1>
        </header>

        <div class="account__body">
            <p class="account__text">View and make changes to your details stored on your account.</p>

            <div class="account-details__container">
                <div class="account-details__detail-section">
                    <p class="account-details__label">Email</p>
                    <p><?= $user['email']?></p>
                </div>

                <div class="account-details__detail-section">
                    <p class="account-details__label">Password</p>
                    <p>************</p>
                    <a href="/reset"></a>
                </div>

                <div class="account-details__detail-section">
                    <p class="account-details__label">Multi-factor authentication</p>
                    <p>Require a secondary password to sign into your account</p>
                    <form method="post" action="/2fa">
                        <button class="button_secondary" type="submit">Setup</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>