<?php
/**
 * Дурацкий движок на PHP
 * @author FoolCMS
 */

function __autoload($class_name) {
    $class_name = str_replace('\\', '/', $class_name);
    require_once(_ROOT_DIR_ . "/" . _CLASS_DIR_ . "/$class_name.php");
}

if (file_exists("include/include.php")) {
    require_once "include/include.php";
}
else { die("Critical Caraul::Cannot find includes file"); }

if (defined("_ROOT_DIR_") && defined("_CLASS_DIR_") && file_exists(_ROOT_DIR_ . "/". _CLASS_DIR_ ."/FoolCMS/Core.php")) {
    require_once _ROOT_DIR_ . "/". _CLASS_DIR_ ."/FoolCMS/Core.php"; //Подключаем ядро CMS
    \FoolCMS\Core::getInstance()->openSite();
}
else { die("Critical Caraul::Cannot initilize CMS core"); }
?>
