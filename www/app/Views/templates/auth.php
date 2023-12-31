<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Sora:wght@700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/styles/index.css">

    <title><?= $title; ?></title>
</head>
<body class="auth">
<main class="auth__main container">
    <div class="auth__form-wrapper">
        <h1 class="auth__heading">Jiggle</h1>
        <?= $content; ?>
    </div>
</main>
</body>
</html>