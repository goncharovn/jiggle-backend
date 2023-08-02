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

    <title><?php echo $title; ?></title>
</head>
<body>
<header class="header">
    <div class="container header__container">
        <a href="/"><h1 class="logo">Jiggle</h1></a>

        <div class="header__buttons">
            <a class="header__signin" href="/login">Sign In</a>
            <a class="basket-notification" href="/basket">
            <!--            <span class="basket-notification__price"></span>-->
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                     aria-hidden="true" class="icon" focusable="false">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M9 2V5H15V2H9ZM17 5V2C17 0.895431 16.1046 0 15 0H9C7.89543 0 7 0.895431 7 2V5H2H0V7V20C0 22.2091 1.79086 24 4 24H20C22.2091 24 24 22.2091 24 20V7V5H22H17ZM17 7H22V20C22 21.1046 21.1046 22 20 22H4C2.89543 22 2 21.1046 2 20V7H7H17Z"></path>
                </svg>
            </a>
        </div>
    </div>
</header>
<main class="main container">
    <?php echo $content; ?>
</main>
</body>
</html>