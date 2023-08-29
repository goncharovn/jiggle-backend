<header class="auth__header">
    <h2 class="auth__subheading">Welcome</h2>

    <p class="auth__message">Please log in to Jiggle to continue</p>
</header>

<?php if (!empty($formError)) : ?>
    <p class="error-message"><?= $formError; ?></p>
<?php endif; ?>

<form class="auth-form login-form" method="post" action="">
    <input class="input" type="email" name="email" placeholder="Email address" required>
    <input class="input" type="password" name="password" placeholder="Enter password" required>

    <a class="auth__link" href="/reset-password">Forgot password?</a>

    <button class="auth-form__button" type="submit">Continue</button>
</form>

<p class="auth__alternate-action">Don't have an account? <a class="auth__link" href="/signup">Sign up</a></p>