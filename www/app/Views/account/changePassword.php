<header class="auth__header">
    <h2 class="auth__subheading">Change Your Password</h2>

    <p class="auth__message">Enter a new password below to change your password.</p>
</header>

<p class="error-message"><?= $errorMessage ?></p>

<form class="auth-form" method="post" action="">
    <input class="input" type="password" name="new_password" placeholder="New password">
    <input class="input" type="password" name="new_password_confirm" placeholder="Re-enter new password">
    <button class="auth-form__button" type="submit">Reset password</button>
</form>