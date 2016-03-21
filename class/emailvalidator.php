<?php
/********************************
 * Класс для проверки email
 ********************************/

class MailValidator {

    private static $instance; // контейнер экземпляра объекта
    private static $pattern = '\b[\w\.-]+@([\w\.-]+\.\w{2,4})\b';
    private $email = null;

    private function __construct() {

    }

    public static function getInstance($str){
        if(empty(self::$instance)){
            self::$instance = new self();
            self::$instance->email = $str;
        }
        return self::$instance;
    }

    public function syntaxCheck() {
        $res = preg_match(self::$pattern, $this->email);
        if ($res > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function isExists() {
        $port = 25;
        preg_match(self::$pattern, $this->email, $match);
        $domain = $match[2];
        $mx_recrds = dns_get_record($domain, DNS_MX);
        if (($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) {
            return "Socket error";
        }
        $result = socket_connect($socket, $domain, $port);
        if ($result === false) {
            return "Error connecting to socket";
        } else {

        }
        $msg = "HELO ";
        socket_write($socket, $msg, strlen($msg));
        $out = socket_read($socket, 1024);
    }

}

?>
