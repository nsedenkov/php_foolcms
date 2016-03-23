<?php
/********************************
 * Класс для проверки email
 ********************************/

class MailValidator {

    private $pattern = '{[\w.-]+@([\w.-]+.\w{2,4})}';
    private $email = null;

    public function __construct($str) {
        $this->email = $str;
    }

    public function isValid() {
        $res = preg_match($this->pattern, $this->email);
        if ($res > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    /*public function isExists() {
        $port = 25;
        preg_match($this->pattern, $this->email, $match);
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
    }*/

}

?>
