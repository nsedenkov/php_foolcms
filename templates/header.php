<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <title><?php \FoolCMS\Core::getInstance()->outPageTitle(); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href=<?php echo "\""; \FoolCMS\Core::getInstance()->outDomName(); echo "css/fool.css" . "\""?> type="text/css">
    </head>
    <body>
    <div class="wrapper">
    <div class="slider slider_count_4">
        <input type="radio" id="selector1" name="selector">
        <input type="radio" id="selector2" name="selector">
        <input type="radio" id="selector3" name="selector">
        <input type="radio" id="selector4" name="selector">
        <div class="item">
            <img alt="" title="" src=<?php echo "\""; \FoolCMS\Core::getInstance()->outDomName(); echo "img/Slider-1.jpg" . "\""?>>
        </div>
        <div class="item">
            <img alt="" title="" src=<?php echo "\""; \FoolCMS\Core::getInstance()->outDomName(); echo "img/Slider-2.jpg" . "\""?>>
        </div>
        <div class="item">
            <img alt="" title="" src=<?php echo "\""; \FoolCMS\Core::getInstance()->outDomName(); echo "img/Slider-3.jpg" . "\""?>>
        </div>
        <div class="item">
            <img alt="" title="" src=<?php echo "\""; \FoolCMS\Core::getInstance()->outDomName(); echo "img/Slider-4.jpg" . "\""?>>
        </div>
        <div class="selector_list">
            <label for="selector1">1</label>
            <label for="selector2">2</label>
            <label for="selector3">3</label>
            <label for="selector3">4</label>
        </div>
    </div>
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
    <?php \FoolCMS\Core::getInstance()->outMainMenu(); ?>
