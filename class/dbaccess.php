<?php
namespace FoolCMS;
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
        $this->mysqli = new \mysqli("localhost", $dbp['user'], $dbp['pswd'], $dbp['dbnm']);
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
        $res = $this->exQuery('SELECT o.id,
                                      o.parent_id,
                                      o.name,
                                      om1.metadata alias,
                                      om2.metadata template,
                                      on1.value,
                                      on2.value numcols
                               FROM objects o
                               LEFT JOIN obj_meta om1 ON (o.id=om1.obj_id AND om1.type=\'alias\')
                               LEFT JOIN obj_meta om2 ON (o.id=om2.obj_id AND om2.type=\'template\')
                               INNER JOIN obj_numdata on1 ON (o.id=on1.obj_id AND on1.type=\'order\')
                               INNER JOIN obj_numdata on2 ON (o.id=on2.obj_id AND on2.type=\'colcount\')
                               WHERE o.type=\'page\'
                               ORDER BY o.parent_id, on1.value');
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

    public function saveNewMsg($in) {
        // в случае успеха возвращает id новой записи в inbox
        $res = -1;
        extract($in);
        $name = $this->mysqli->real_escape_string($name);
        $subject = $this->mysqli->real_escape_string($subject);
        $email = $this->mysqli->real_escape_string($email);
        $message = $this->mysqli->real_escape_string($message);
        if ($this->exQuery("INSERT INTO inbox(name,subject,email,message) VALUES (\"$name\",\"$subject\",\"$email\",\"$message\")")) {
            $res = $this->mysqli->insert_id;
        }
        return $res;
    }
}
?>
