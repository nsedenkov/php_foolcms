<?php
/**
 * Дурацкий движок на PHP
 * @author FoolCMS
 */
include_once "router.php";
include_once "objman.php";

class FoolCore extends Router {

    // применяем паттерн Singleton
    private static $instance; // контейнер для экземпляра
    private $_page_file = null;
    private $_error = null;
    private $request_uri = null;
    private $proto = null;
    private $domain = null;
    private $title = null;
    private $numcols = 1;

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
        }
         //Если URI отсутствует, то открываем главную
        else {
            $this->_page_file = "front-page";
        }
        $this->title = $this->getHeader($uri);
        $this->numcols = $this->getNumCols($uri);
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

    public function openSite() {
        include_once _ROOT_DIR_ . "/" . _TEMPLATE_DIR_ . "/" . _HEADER_; //Подключаем шапку сайта
        if ($this->getError()) { //Если возникли ошибки, выводим сообщение на экран
            echo "<div style='border:1px solid red;padding:10px;margin: 10px auto;
                width: 500px;'>" . $this->getError() . "</div>";
        }
        switch ($this->numcols) {
            case 2: echo "<section class=\"mainfield\">";
                    break;
            default: echo "<section class=\"single\">";
                    break;
        }
        include_once $this->getContentPage(); //Выводим страницы сайта
        echo "</section>";
        switch ($this->numcols) {
            case 2: include_once _TEMPLATE_DIR_ . "/" . _SIDEBAR_;
                    echo "<div class=\"cf\"></div>";
                    break;
            default:
                    break;
        }
        include_once _ROOT_DIR_ . "/" . _TEMPLATE_DIR_ . "/" . _FOOTER_;//Подключаем подвал сайта
    }

    /**
     * Возвращает текст открытой страницы
     */
    private function getContentPage() {
        $res = "templates/" . $this->_page_file . ".php";
        return $res;
    }

    private function getDomName() {
        return $this->proto . "://" . $this->domain . "/";
    }

    public function outDomName() {
        echo $this->getDomName();
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
        foreach(parent::getAllRoutes() as $key=>$route){
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

    private function getMainMenu(){
        $openTag = "<nav class=\"fool-menu\">";
        $closeTag = "</nav>";
        $res = $openTag . $this->getSubMenu(-1) . $closeTag;
        return $res;
    }

    public function outMainMenu(){
        echo $this->getMainMenu();
    }

    private function getPageTitle() {
        return $this->title;
    }

    public function outPageTitle() {
        echo $this->getPageTitle();
    }

    private function getParam($name){
        return parent::getSingleParam($name);
    }

    public function outParam($name){
        echo $this->getParam($name);
    }

}
?>
