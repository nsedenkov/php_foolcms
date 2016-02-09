<?php
/**
 * Дурацкий движок на PHP
 * @author FoolCMS
 */
include_once "router.php";

class Engine extends Router {

    private $_page_file = null;
    private $_error = null;
    private $request_uri = null;
    private $url_info = null;

    public function __construct() {
        parent::__construct();
        // Сохранить имя домена для пермалинков
        $this->domain = $_SERVER['SERVER_NAME'];
        // Разобрать URI
        $this->request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->url_info = parse_url($this->request_uri);
        $uri = urldecode($this->url_info['path']);
        file_put_contents('foollog.txt', $this->request_uri);
        file_put_contents('foollog.txt', $this->url_info);
        file_put_contents('foollog.txt', $uri);
        if ($uri != '/') { //Если открыта какая-нибудь страница
            //Небольшая защита
            $uri = str_replace(".", null, $uri);
            $uri = str_replace("/", null, $uri);
            $uri = str_replace("", null, $uri);

            //разрешаем маршрут в имя шаблона
            $this->_page_file = $this->getRoute($uri);

        }
         //Если URI отсутствует, то открываем главную
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
        $res = "templates/" . $this->_page_file . ".php";
        return $res;
    }
    /***
     * Сборка главного меню
     */
    // Сборка подменю для указанного пункта верхнего уровня
    private function getSubMenu($id){
        
    }
    public function getMainMenu(){
        $openTag = "<nav class=\"fool-menu\"><ul>";
        $closeTag = "<\/ul><\/nav>";
        $body = "";
        $str = "";
        foreach($this->_route as $key => $route){
            if($route["id"] == -1){
                $str = 
            }
        }
    }
}
?>
