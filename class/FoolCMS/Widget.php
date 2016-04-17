<?php
namespace FoolCMS;

class Widget extends FoolObject {

    private function loadObject($id) {
        $res = Dbaccess::getInstance()->getOneObject($id);
        // res - массив с ключами name, dt_create, content
        // или False, если id не существует
        if ($res) {
            return $this->formatString($res);
        }
        else {
            return $res; // вернуть false в случае неудачи
        }
    }

    private function formatString($obj) {
        $open = "<div class=\"widget\">";
        $close = "</div>";
        $w_hdr = "";
        $w_cnt = "";
        if(array_key_exists("name", $obj)) {
            $w_hdr = "<h3 class=\"w-title\">" . $obj["name"] . "</h3>";
        }
        if(array_key_exists("content", $obj)) {
            $w_cnt = $obj["content"];
        }
        return $open . $w_hdr . $w_cnt . $close;
    }

    public function get($id) {
        $res = false;
        $res = $this->loadObject($id);
        return $res;
    }
}

?>
