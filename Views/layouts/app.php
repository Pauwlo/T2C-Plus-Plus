<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    <meta name="robots" content="noindex, nofollow">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="T2C++">
    <meta name="apple-mobile-web-app-status-bar-style" content="<?= $dayMode ? 'default' : 'black-translucent' ?>">

    <title><?= $title ?></title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" id="style-<?= $dayMode ? 'day' : 'default' ?>" href="./public/css/app<?= $dayMode ? '-day' : '' ?>.css">
	<link rel="apple-touch-icon" href="apple-touch-icon.png">

    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-65644846-5"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-65644846-5');
    </script>
</head>

<body>

    <?= $content ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="./public/js/app.js"></script>
    <?= $scripts ?? '' ?>
</body>

</html>
