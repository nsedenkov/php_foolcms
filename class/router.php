<?php

/**
 * Класс для обработки ЧПУ-запросов
 */
class Router {
    private $_route = array(); //Переменная хранит маршруты, и файлы, которые будут открываться при определеном маршруте
    private $_names = array(); //Переменная хранит "человеческие" имена страниц

    public function __construct(){
        $this->readRoutes();
    }

    /**
     * Метод для установки маршрута, и файла который будет открываться при заданом маршруте
     * @param <string> $dir - маршрут
     * @param <string> $file - адрес файла
     * @param <string> $name - "человеческое" имя страницы
     */
    private function setRoute($dir, $file, $name) {
        $this->_route[trim($dir, "/")] = $file;
        $this->_names[trim($dir, "/")] = $name;
    }

    /**
     * Метод инициализации таблицы маршрутов из БД
     * таблица objects
     * objects.type -> page
     */
    private function readRoutes() {
        /* TODO: не хардкодить параметры соединения */
        $mysqli = new mysqli("localhost", "u597389257_fcms", "XsHU:#gGk74th!V", "u597389257_fool");
        if ($mysqli->connect_errno) {
            echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        else {
            $res = $mysqli->query('SELECT id,parent_id,name,alias,template FROM objects WHERE type=\'page\'');
            if ($res->num_rows > 0){
                while($row = $res->fetch_assoc()){
                    $this->setRoute($row['alias'], $row['template'], $row['name']);
                }
            }
        }
    }

    public function getRoute($dir){
        if(strlen(trim($dir, "/")) == 0){
            return "front-page";
        }
        elseif($this->_route[trim($dir, "/")]){
            return "page-" . $this->_route[trim($dir, "/")];
        }
        else{
            return "FOOL_ROUTE_ERROR";
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
}

/*
$route = new Router;
$route->setRoute("page/article-1/", "1.html"); //Устанавливаем маршрут "page/article-1/", и файл который будет открываться при этом маршруте
$route->setRoute("article-2", "2.html");
if (!$route->route()) { //Если маршрут не задан..
    echo "Маршрут не задан";

}*/

?>
