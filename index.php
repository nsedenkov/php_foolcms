<?php
/**
 * Дурацкий движок на PHP
 * @author FoolCMS
 */
include_once "class/core.php"; //Подключаем ядро CMS

include_once "templates/header.php"; //Подключаем шапку сайта

if (FoolCore::getInstance()->getError()) { //Если возникли ошибки, выводим сообщение на экран
    echo "<div style='border:1px solid red;padding:10px;margin: 10px auto;
        width: 500px;'>" . FoolCore::getInstance()->getError() . "</div>";
}
include_once FoolCore::getInstance()->getContentPage(); //Выводим страницы сайта

include_once "templates/footer.php";//Подключаем подвал сайта
FoolCore::getInstance()->destroy();
?>
