<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <title><?php Engine::getInstance()->getPageTitle(); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="css/fool.css" type="text/css">
    </head>
    <body>
    <div class="wrapper">
    <div class="left-menu">
        <div class="navbar-header">
            <button type="button" id="m-btn" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
    </div>
    <?php Engine::getInstance()->getMainMenu(); ?>
