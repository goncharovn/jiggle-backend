<header class="auth__header">
    <h2 class="auth__subheading">Enter code</h2>

    <p class="auth__message">Enter the code sent to your email.</p>
</header>

<p class="error-message"><?= $errorMessage ?></p>

<form class="auth-form" method="post" action="">
    <input class="input" name="two_factor_code" placeholder="Two-factor code">
    <button class="auth-form__button" type="submit">Continue</button>
</form>