<?php
/**
 * Дурацкий движок на PHP
 * @author FoolCMS
 */
if (file_exists("include/include.php")) {
    require_once "include/include.php";
}
else { die("Critical Caraul::Cannot find includes file"); }

if (defined("_ROOT_DIR_") && defined("_CLASS_DIR_") && file_exists(_ROOT_DIR_ . "/". _CLASS_DIR_ ."/core.php")) {
    require_once _ROOT_DIR_ . "/". _CLASS_DIR_ ."/core.php"; //Подключаем ядро CMS
    \FoolCMS\Core::getInstance()->openSite();
}
else { die("Critical Caraul::Cannot initilize CMS core"); }
?>
