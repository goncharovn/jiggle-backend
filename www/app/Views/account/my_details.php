<div class="account">
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
                    <p class="account-details__label">
                        <span>Name</span>
                        <button class="edit-name-button edit-button_active edit-button" href="">Edit</button>
                    </p>
                    <?php if (!empty($user->getName())) : ?>
                        <p><?= $user->getName() ?></p>
                    <?php endif; ?>

                    <form class="edit-name-form edit-form" action="/change-name" method="post">
                        <label for="first-name">First Name*</label>
                        <input class="input" type="text" placeholder="First Name" id="first-name" name="first_name" required>
                        <label for="last-name">Last Name*</label>
                        <input class="input" type="text" placeholder="Last Name" id="last-name" name="last_name" required>

                        <div class="edit-form__button-container">
                            <button class="apply-button" type="submit">Apply</button>
                            <button class="reset-name-button" type="reset">Cancel</button>
                        </div>
                    </form>
                </div>

                <div class="account-details__detail-section">
                    <p class="account-details__label">
                        <span>Email</span>
                        <button class="edit-email-button edit-button edit-button_active" href="">Edit</button>
                    </p>
                    <p><?= $user->getEmail() ?></p>

                    <form class="edit-email-form edit-form" action="/change-email" method="post">
                        <label for="email">Email*</label>
                        <input class="input" type="email" placeholder="Email" id="email" name="email">

                        <div class="edit-form__button-container">
                            <button class="apply-button" type="submit">Apply</button>
                            <button class="reset-email-button" type="reset">Cancel</button>
                        </div>
                    </form>

                    <?= $emailMessage; ?>
                </div>

                <div class="account-details__detail-section">
                    <p class="account-details__label">
                        <span>Password</span>
                        <a class="edit-button edit-button_active" href="/reset-password">Reset</a>
                    </p>
                    <p>************</p>
                </div>

                <div class="account-details__detail-section">
                    <p class="account-details__label">Multi-factor authentication</p>

                    <?php if ($user->isTwoFactorAuthEnabled()): ?>
                        <form method="post" action="/login/disable-2fa">
                            <button class="button_secondary" type="submit">Disable</button>
                        </form>
                    <?php else: ?>
                        <p>Require a secondary password to sign in to your account</p>

                        <form method="post" action="/login/enable-2fa">
                            <button class="button_secondary" type="submit">Enable</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>