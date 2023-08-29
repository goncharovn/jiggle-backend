<div class="account">
    <?= $accountMenu ?>

    <div class="account__info">
        <header class="account__header">
            <h1 class="account__heading">Hi!</h1>
        </header>

        <div class="account__body">
            <p class="account__text">Welcome to your account overview, a snapshot of your account and recent activities.
                Click for a more detailed view of your account information.</p>

            <div class="account-overview__details">
                <div class="account__card">
                    <p class="account__card-heading">Addresses</p>

                    <p class="account-overview__subheading">Default delivery address</p>

                    <a class="account__view" href="/my-account/delivery-address">View</a>
                </div>

                <div class="account__card">
                    <p class="account__card-heading">Details</p>

                    <p class="account-overview__subheading">Your details</p>

                    <p><?= $user->getName() ?></p>

                    <p><?= $user->getEmail() ?></p>

                    <a class="account__view" href="/my-account/my-details">View</a>
                </div>
            </div>
        </div>
    </div>
</div>