<?php
/**
 * Дурацкий движок на PHP
 * @author FoolCMS
 */
include_once "class/engine.php"; //Подключаем класс-движка
$engine = new Engine(); //Создаем объект класса Engine

include_once "templates/header.php"; //Подключаем шапку сайта

if ($engine->getError()) { //Если возникли ошибки, выводим сообщение на экран
    echo "<div style='border:1px solid red;padding:10px;margin: 10px auto;
        width: 500px;'>" . $engine->getError() . "</div>";
}
echo $engine->getContentPage(); //Выводим страницы сайта

include_once "templates/footer.php";//Подключаем подвал сайта
?>
