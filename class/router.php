<?php

/**
 * Класс для обработки ЧПУ-запросов
 */
class Router {
    protected $_route = array(); //Переменная хранит маршруты, и файлы, которые будут открываться при определеном маршруте

    public function __construct(){
        $this->readRoutes();
    }

    /*
     * Ищет "родителя" для представления uri в виде "раздел/подраздел"
     */
    private function findParent($id) {
        foreach($this->_route as $key=>$value){
            if($value["id"] == $id){
                if($value["pid"] > -1){
                    return $this->findParent($value["pid"]) . "/" . $key;
                }
                else {
                    return $key;
                }
            }
        }
    }

    /**
     * Метод для установки маршрута, и файла который будет открываться при заданом маршруте
     * @param <string> $dir - маршрут
     * @param <string> $file - адрес файла
     * @param <string> $name - "человеческое" имя страницы
     */
    private function setRoute($dir, $file, $name, $id, $pid) {
        $uri =  trim($dir, "/");
        if($pid > -1){
            $uri = $this->findParent($pid) . "/" . $uri;
        }
        if(!$this->_route[$uri]){
            $this->_route[$uri] = array ("file" => $file,
                                         "name" => $name,
                                         "id" => $id,
                                         "pid" => $pid);
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Метод инициализации таблицы маршрутов из БД
     * таблица objects
     * objects.type -> page
     */
    private function readRoutes() {
        $json = file_get_contents('dbcfg.json');
        $dbp = json_decode($json, true);
        $mysqli = new mysqli("localhost", $dbp['user'], $dbp['pswd'], $dbp['dbnm']);
        if ($mysqli->connect_errno) {
            echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        else {
            $res = $mysqli->query('SELECT id,parent_id,name,alias,template,_order FROM objects WHERE type=\'page\'
                                   ORDER BY parent_id, _order');
            if ($res->num_rows > 0){
                while($row = $res->fetch_assoc()){
                    $this->setRoute($row['alias'], $row['template'], $row['name'], $row['id'], $row['parent_id']);
                }
            }
        }
        $mysqli->close();
    }

    public function getRoute($dir){
        if(strlen(trim($dir, "/")) == 0){
            return "front-page";
        }
        elseif($this->_route[trim($dir, "/")]){
            return $this->_route[trim($dir, "/")]["file"];
        }
        else{
            return "_404";
        }
    }

    protected function getHeader($dir){
        if(strlen(trim($dir, "/")) == 0){
            return "SITE_HEADER"; // Заменить на глобальный заголовок сайта из БД
        }
        elseif($this->_route[trim($dir, "/")]){
            return $this->_route[trim($dir, "/")]["name"] . " >> " . "SITE_HEADER";
        }
        else{
            return "_404";
        }
    }

    /**
     * Метод смотрит текущий адрес, и сверяет его с установленными маршрутами,
     * если для открытого адреса установлен маршрут, то открываем страницу
     * @return <boolean>
     */
    public function route() {
        if (!isset($_SERVER["PATH_INFO"])) { //Если открыта главная страница
            include_once "index.html"; //Открываем файл главной страницы
        } elseif (isset($this->_route[trim($_SERVER["PATH_INFO"], "/")])) { //Если маршрут задан
            include_once $this->_route[trim($_SERVER["PATH_INFO"], "/")]; //Открываем файл, для которого установлен маршрут
        }
        else return false; //Если маршрут не задан

        return true;
    }

    public function getAllRoutes() {
        $res = null;
        foreach($this->_route as $one) {
            $res .= $one;
        }
        return $res;
    }
}

/*
$route = new Router;
$route->setRoute("page/article-1/", "1.html"); //Устанавливаем маршрут "page/article-1/", и файл который будет открываться при этом маршруте
$route->setRoute("article-2", "2.html");
if (!$route->route()) { //Если маршрут не задан..
    echo "Маршрут не задан";

}*/

?>
