<?php
namespace FoolCMS;

/*include_once "dbaccess.php";*/
/**
 * Класс для обработки ЧПУ-запросов
 */
abstract class Router {
    private $_fooldb = null;
    private $_route = array(); //Переменная хранит маршруты, и файлы, которые будут открываться при определеном маршруте

    protected function __construct(){
        $this->_fooldb = Dbaccess::getInstance();
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
     * @param <string> $alias - маршрут
     * @param <string> $file - имя файла
     * @param <string> $name - "человеческое" имя страницы
     */
    private function setRoute($ar) {
        extract($ar);
        $uri =  trim($alias, "/");
        if($parent_id > -1){
            $uri = $this->findParent($parent_id) . "/" . $uri;
        }
        if(!isset($this->_route[$uri])){
            $this->_route[$uri] = array ("file" => $template,
                                         "name" => $name,
                                         "id" => $id,
                                         "pid" => $parent_id,
                                         "nc" => $numcols);
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
                $this->setRoute($row);
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
        //$s_hdr = getSingleParam('fool_header');
        $s_hdr = $this->_fooldb->getOneGeneral('fool_header');
        if(strlen(trim($dir, "/")) == 0){
            return $s_hdr;
        }
        elseif($this->_route[trim($dir, "/")]){
            return $this->_route[trim($dir, "/")]["name"] . " >> " . $s_hdr;
        }
        else{
            return "_404";
        }
    }

    protected function getNumCols($dir) {
        if(strlen(trim($dir, "/")) == 0){
            return 2;
        }
        elseif($this->_route[trim($dir, "/")]){
            return $this->_route[trim($dir, "/")]["nc"];
        }
        else{
            return 1;
        }
    }

    protected function getSingleParam($name){
        $res = $this->_fooldb->getOneGeneral($name);
        if ($res) {
            return $res;
        }
        else {
            return "NONE";
        }
    }

    protected function getAllRoutes() {
        return $this->_route;
    }
}

?>
