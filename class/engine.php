<?php
/**
 * Дурацкий движок на PHP
 * @author FoolCMS
 */
include_once "router.php";

class Engine extends Router {

    private $_page_file = null;
    private $_error = null;

    public function __construct() {
        parent::__construct();
        if (isset($_GET["page"])) { //Если открыта какая-нибудь страница
            //Записываем в переменную алиас (из GET запроса)
            $dir = $_GET["page"];
            //Небольшая защита
            $dir = str_replace(".", null, $dir);
            $dir = str_replace("/", null, $dir);
            $dir = str_replace("", null, $dir);

            //разрешаем маршрут в имя шаблона
            $this->_page_file = $this->getRoute($dir);

        }
         //Если в GET запросе нет переменной page, то открываем главную
        else {
            $this->_page_file = "front-page";
        }
    }

    /**
     * Записывает ошибку в переменную _error
     * @param string $error - текст ошибки
     */
    private function _setError($error) {
        $this->_error = $error;
    }

    /**
     * Возвращает текст ошибки
     */
    public function getError() {
        return $this->_error;
    }

    /**
     * Возвращает текст открытой страницы
     */
    public function getContentPage() {
        return file_get_contents("templates/" . $this->_page_file . ".php");
    }

}
?>
