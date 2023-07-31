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

    <link rel="stylesheet" href="/styles/index.css">

    <title><?php echo $title; ?></title>
</head>
<body>
<header class="header">
    <div class="container header__container">
        <a href="/"><h1 class="logo">Jiggle</h1></a>
    </div>
</header>
<main class="main container">
    <?php echo $content; ?>
</main>
</body>
</html>