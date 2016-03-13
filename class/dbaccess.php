<?php
/********************************
 * Класс для доступа к БД
 * Использует mysqli
 ********************************/

final class FoolDB{

    // Применяем паттерн Singleton
    private static $instance; // контейнер экземпляра объекта
    private $mysqli = null;
    private $isActive = false;

    // для предотвращения создания извне через new FoolDB
    private function __construct(){
        $json = file_get_contents('dbcfg.json');
        $dbp = json_decode($json, true);
        $this->mysqli = new mysqli("localhost", $dbp['user'], $dbp['pswd'], $dbp['dbnm']);
        if ($this->mysqli->connect_errno) {
            echo "Не удалось подключиться к MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
        }
        else{
            $this->isActive = true;
            $this->exQuery("SET NAMES utf8");
            $this->exQuery("SET CHARACTER SET utf8");
        }
    }

    public function destroy(){
        // Закрыть соединение с БД
        if($this->isActive){
            $this->mysqli->close();
        }
    }

    public static function getInstance(){
        if(empty(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function exQuery($qstr){
        // Выполняет произвольный запрос к БД
        $res = null;
        if($this->isActive){
            $res = $this->mysqli->query($qstr);
        }
        return $res;
    }

    public function getOneGeneral($name){
        // Возвращает параметр из таблицы General по имени
        $res = false;
        if($this->isActive){
            $qry = $this->exQuery("SELECT id,value FROM general WHERE name=\"$name\" ORDER BY id DESC");
            if($qry->num_rows>0){
                $row = $qry->fetch_assoc();
                $res = $row['value'];
            }
        }
        return $res;
    }

    public function getAllRoutes(){
        $res = $this->exQuery('SELECT id,parent_id,name,alias,template,_order FROM objects WHERE type=\'page\'
                               ORDER BY parent_id, _order');
        return $res;
    }

    public function getAllObjects($type) {
        // возвращает массив с id объектов заданного типа
        $res = array();
        $qry = $this->exQuery("SELECT id FROM objects WHERE type=\"$type\"");
        if ($qry->num_rows > 0) {
            while ($row = $qry->fetch_assoc()) {
                $res[] = $row["id"];
            }
        }
        if (count($res) > 0) {
            return $res;
        }
        else {
            return false;
        }
    }

    public function getOneObject($id) {
        // возвращает один объект по id
        $res = array();
        $qry = $this->exQuery("SELECT name,dt_create,content FROM objects WHERE id=\"$id\"");
        if ($qry->num_rows > 0) {
            $res = $qry->fetch_assoc();
        }
        if (count($res) > 0) {
            return $res;
        }
        else {
            return false;
        }
    }
}
?>
