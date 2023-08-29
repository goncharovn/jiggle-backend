<header class="auth__header">
    <h2 class="auth__subheading">Forgotten Password</h2>

    <p class="auth__message">Enter your email address, and we will send you instructions to reset your password</p>
</header>

<p class="error-message"><?= $errorMessage ?></p>

<form class="auth-form" method="post" action="">
    <input class="input" type="email" name="email" placeholder="Email address">
    <button class="auth-form__button" type="submit">Continue</button>
</form>

<a class="auth__link auth__back" href="/login">Back to login</a>