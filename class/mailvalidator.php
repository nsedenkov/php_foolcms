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
        $res = preg_match($this->pattern, $this->email, $match);
        if (($res > 0) && (strlen($match[0]) == strlen($this->email))) {
            return true;
        }
        else {
            return false;
        }
    }

    public function isExists() {
        $port = 25;
        preg_match($this->pattern, $this->email, $match);
        $domain = $match[1];
        if (($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) {
            return "Socket error";
        }
        $mx_records = dns_get_record($domain, DNS_MX);
        if (count($mx_records) > 0) {
            $result = socket_connect($socket, $mx_records[0]["target"], $port);
            if ($result === false) {
                return "Error connecting to socket";
            } else {
                $tmp = $this->email;
                $msg = array();
                $msg[] = "HELO $domain";
                $msg[] = "MAIL FROM: test@test.ru";
                $msg[] = "RCPT TO: $tmp";
                for (i = 0; i < 3; i++) {
                    socket_write($socket, $msg[i], strlen($msg[i]));
                    $out = socket_read($socket, 1024);
                }
                if (strpos($out, "25") !== false) {
                    return true;
                }
                else {
                    return false;
                }
            }
        }
        else {
            return false;
        }
    }

}

?>
