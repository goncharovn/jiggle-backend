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
<body class="admin">
<div class="admin__menu">
    <h2 class="admin__heading">Admin</h2>
    <nav class="admin__nav">
        <ul class="admin__menu-list">
            <li class="admin__menu-item">
                <a class="admin__menu-link" href="/admin/products">
                    <img src="/img/bag.svg" alt="">
                    Products
                </a>
            </li>
            <li class="admin__menu-item">
                <a class="admin__menu-link" href="/admin/orders">
                    <img src="/img/list.svg" alt="">
                    Orders
                </a>
            </li>
            <li class="admin__menu-item">
                <a class="admin__menu-link" href="/admin/customers">
                    <img src="/img/user.svg" alt="">
                    Customers
                </a>
            </li>
            <li class="admin__menu-item">
                <a class="admin__menu-link" href="/my-account/my-details">
                    <img src="/img/home.svg" alt="">
                    My account
                </a>
            </li>
        </ul>
    </nav>
</div>
<div class="admin__content">
    <?= $content; ?>
</div>

</body>
</html>