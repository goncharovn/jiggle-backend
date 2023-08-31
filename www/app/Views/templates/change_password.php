<form class="auth-form" method="post" action="/process-change-password<?= $parametersString ?>">
    <input class="input" type="password" name="new_password" placeholder="New password">
    <input class="input" type="password" name="new_password_confirm" placeholder="Re-enter new password">
    <button class="auth-form__button" type="submit">Reset password</button>
</form>