<form class="auth-form login-form" method="post" action="/process-signup">
    <input class="input" type="email" name="email" value="<?= $email ?>" placeholder="Email address" required>
    <input class="input" type="password" name="password" placeholder="Enter password" required>

    <button class="auth-form__button" type="submit">Continue</button>
</form>

<p class="auth__alternate-action">Already have an account? <a class="auth__link" href="/login">Sign in</a></p>