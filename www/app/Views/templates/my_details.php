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
            <a class="edit-button edit-button_active" href="/process-reset-password">Reset</a>
        </p>
        <p>************</p>
    </div>

    <div class="account-details__detail-section">
        <p class="account-details__label">Multi-factor authentication</p>

        <p>Require a secondary password to sign in to your account</p>

        <form method="post" action="/login/toggle-multi-factor-auth">
            <button class="button_secondary" type="submit">
                <?php if ($user->isMultiFactorAuthEnabled()): ?>
                    Disable
                <?php else: ?>
                    Enable
                <?php endif; ?>
            </button>
        </form>
    </div>
</div>