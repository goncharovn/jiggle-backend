<header class="auth__header">
    <h2 class="auth__subheading">Enter code</h2>
    <p class="auth__message">Enter the code sent to your email.</p>
</header>

<?php if (!empty($formError)) : ?>
    <p class="error-message"><?= $formError; ?></p>
<?php endif; ?>

<form class="auth-form" method="post" action="/login/process-multi-factor-auth">
    <input class="input" name="multi_factor_auth_code" placeholder="Two-factor code">
    <button class="auth-form__button" type="submit">Continue</button>
</form>