<?php
/**
 * Дурацкий движок на PHP
 * @author FoolCMS
 */
include_once "router.php";

class Engine extends Router {

    // применяем паттерн Singleton
    private static $instance; // контейнер для экземпляра
    private $_page_file = null;
    private $_error = null;
    private $request_uri = null;
    private $proto = null;
    private $domain = null;
    private $title = null;

    private function getEnvVar(){
        // Сохранить имя домена для пермалинков
        $this->proto = $_SERVER['REQUEST_SCHEME'];
        if(isset($_SERVER['HTTP_HOST'])){
            $this->domain = $_SERVER['HTTP_HOST'];
        }
        else{
            $this->domain = $_SERVER['SERVER_NAME'];
        }
        // Разобрать URI
        $this->request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    private function getUri(){
        $res = null;
        $this->getEnvVar();
        $url_info = parse_url($this->request_uri);
        $res = urldecode($url_info['path']);
        return $res;
    }

    private function resolvePage() {
        $uri = $this->getUri();
        if ($uri != '/') { //Если открыта какая-нибудь страница
            //Небольшая защита
            $uri = str_replace(".", null, $uri);
            $uri = trim($uri, "/");
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

    protected function __construct() {
        parent::__construct();
        $this->resolvePage();
    }

    public function destroy(){
        parent::destroy();
    }

    // возвращает единственный экземпляр
    public static function getInstance(){
        if(empty(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
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

    public function getDomName() {
        return $this->proto . "://" . $this->domain . "/";
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

    public function getParam($name){
        return parent::getSingleParam($name);
    }

}
?>
