<?php

include_once "dbaccess.php";
/**
 * Класс для обработки ЧПУ-запросов
 */
abstract class Router {
    private $_fooldb = null;
    private $_route = array(); //Переменная хранит маршруты, и файлы, которые будут открываться при определеном маршруте

    protected function __construct(){
        $this->_fooldb = FoolDB::getInstance();
        $this->readRoutes();
    }

    protected function destroy(){
        if(isset($this->_fooldb)){
            $this->_fooldb->destroy();
        }
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
        // res - результат запроса mysqli
        $res = $this->_fooldb->getAllRoutes();
        if ($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $this->setRoute($row['alias'], $row['template'], $row['name'], $row['id'], $row['parent_id']);
            }
        }
    }

    protected function getRoute($dir){
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

    protected function getSingleParam($name){
        return $this->_fooldb->getOneGeneral($name);
    }

    protected function getAllRoutes() {
        return $this->_route;
    }
}

?>
