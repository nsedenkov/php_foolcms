<?php
/********************************
 * Класс для доступа к БД
 * Использует mysqli
 ********************************/

class FoolDB{

    private $mysqli = null;
    private $isActive = false;

    public function __construct(){
        $json = file_get_contents('dbcfg.json');
        $dbp = json_decode($json, true);
        $this->mysqli = new mysqli("localhost", $dbp['user'], $dbp['pswd'], $dbp['dbnm']);
        if ($this->mysqli->connect_errno) {
            echo "Не удалось подключиться к MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
        }
        else{
            $this->isActive = true;
        }
    }

    public function destroy(){
        if($this->isActive){
            $this->mysqli->close();
        }
    }

    public function exQuery($qstr){
        $res = null;
        if($this->isActive){
            $res = $this->mysqli->query($qstr);
        }
        return $res;
    }
}
?>
