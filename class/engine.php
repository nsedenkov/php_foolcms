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
    private $proto = null;
    private $domain = null;
    private $title = null;

    public function __construct() {
        parent::__construct();
        // Сохранить имя домена для пермалинков
        $this->proto = $_SERVER['REQUEST_SCHEME'];
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
            $this->title = $this->getHeader($uri);
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

    /*
     * Возвращает полную ссылку вида "домен/страница"
     */
    private function getPermalink($dir) {
        return $this->proto . "://" . $this->domain . "/" . $dir;
    }
    /***
     * Сборка главного меню
     */
    // Сборка подменю для указанного пункта верхнего уровня
    private function getSubMenu($id){
        $openTag = "<ul>";
        $closeTag = "</ul>";
        $body = "";
        $href="";
        $submenu = "";
        /*if($id == -1){
            $body = "<li><a href=\"/\">Главная</a></li>";
        }*/
        foreach($this->_route as $key=>$route){
            if($route["pid"] == $id){
                $href = $this->getPermalink($key);
                $submenu = $this->getSubMenu($route["id"]);
                $body .= "<li><a href=\"$href\">$route[name]</a>$submenu</li>";
            }
        }
        if(strlen($body) != 0){
            return $openTag . $body . $closeTag;
        }
        else{
            return false;
        }
    }

    public function getMainMenu(){
        $openTag = "<nav class=\"fool-menu\">";
        $closeTag = "</nav>";
        $res = $openTag . $this->getSubMenu(-1) . $closeTag;
        echo $res;
    }

    public function getPageTitle() {
        echo $this->title;
    }

}
?>
