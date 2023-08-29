<header class="auth__header">
    <h2 class="auth__subheading"><?= $subheading ?></h2>

    <p class="auth__message"><?= $message ?></p>
</header>

<?php if (!empty($errorMessage)) : ?>
    <p class="error-message"><?= $errorMessage ?></p>
<?php endif; ?>

<?php if (!empty($form)) : ?>
    <?= $form ?>
<?php endif; ?>