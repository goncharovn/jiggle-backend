<header class="auth__header">
    <h2 class="auth__subheading">Welcome</h2>

    <p class="auth__message">Create your account to continue</p>
</header>

<p class="error-message"><?= $errorMessage; ?></p>

<form class="auth-form login-form" method="post" action="">
    <input class="input" type="email" name="email" value="<?= $email ?>" placeholder="Email address" required>
    <input class="input" type="password" name="password" placeholder="Enter password" required>

    <button class="auth-form__button" type="submit">Continue</button>
</form>

<p class="auth__alternate-action">Already have an account? <a class="auth__link" href="/login">Sign in</a></p>