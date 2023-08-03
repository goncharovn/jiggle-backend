<header class="auth__header">
    <h2 class="auth__subheading">Welcome</h2>

    <p class="auth__message">Please log in to Jiggle to continue</p>
</header>

<form class="auth-form login-form" action="/handle-login">
    <input class="input" type="email" placeholder="Email address">
    <input class="input" type="password" placeholder="Enter password">

    <a class="auth__link" href="/reset-password">Forgot password?</a>

    <button class="auth-form__button" type="submit">Continue</button>
</form>

<p class="auth__alternate-action">Don't have an account? <a class="auth__link" href="/signup">Sign up</a></p>