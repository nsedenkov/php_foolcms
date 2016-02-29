<?php

include_once "dbaccess.php";

class ObjRegistry {
    // Паттерн Singleton registry
    // Использование:
    // foreach (ObjRegistry::getInstance->get("post") as $postid) ...
    private static $instance = null;
    private static $types = array("post", "plugin");
    private $objects = array();

    private function __construct() {
    }

    private function __wakeup() {
    }

    private function __clone(){
    }

    public static function getInstance(){
        if(empty(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function fill(){
        foreach(self::$types as $type) {
            $res = FoolDB::getInstance()->getAllObjects($type);
            if ($res) {
                self::set($type, $res);
            }
        }
    }

    public static function set($key, $object) {
        self::getInstance()->objects[$key] = $object;
    }

    public static function get($key) {
        if (array_key_exists($key, self::getInstance()->objects)) {
            return self::getInstance()->objects[$key];
        }
        else {
            return false;
        }
    }

} // ObjRegistry

interface IObject {
    public static function initial($type);
    //function loadObject($id);
}

abstract class FoolObject implements IObject {
    //Паттерн Фабрика
    public static function initial($type) {
        $cname = ucfirst(strtolower($type));
        return new $cname();
    }

    //abstract function loadObject($id);
}

class Plugin extends FoolObject {
    private function loadObject($id) {

    }
}

class Post extends FoolObject {
    private function loadObject($id) {
        $res = FoolDB::getInstance()->getOneObject($id);
        // res - массив с ключами name, dt_create, content
        // или False, если id не существует
        if ($res) {
            return $this->formatHTML($res);
        }
        else {
            return $res; // вернуть false в случае неудачи
        }
    }

    private function formatHTML($obj) {
        $pattern_text_full = '{(\[text\].*?\[/text\])}';
        $pattern_text_contents = '{(\[text\](.*?)\[/text\])}';
        $pattern_p_full = '{(\[p\].*?\[/p\])}';
        $pattern_p_contents = '{(\[p\](.*?)\[/p\])}';
        $open = "<article>";
        $close = "</article>";
        $post_hdr = "";
        $post_txt = "";
        if(array_key_exists("name", $obj)) {
            $post_hdr = "<header class=\"post-header\"><h3 class=\"header\">" .
                        $obj["name"] .
                        "</h3></header>";
        }
        if(array_key_exists("content", $obj)) {
            $content = $obj["content"];
            preg_match($pattern_text_contents, $content, $tmp);
            $content = preg_replace($pattern_text_full, "<noindex><div class=\"post-entry\">$tmp[2]</div></noindex>", $content);
            unset($tmp);
            preg_match_all($pattern_p_contents, $content, $tmp);
            foreach($tmp as $match) {
                $content = preg_replace($pattern_p_full, "<p>$match[2]</p>", $content);
            }
            $post_txt = $content;
        }
        return $open . $post_hdr . $post_txt . $close;
    }

    public function get($id) {
        $res = false;
        $res = $this->loadObject($id);
        return $res;
    }
}

?>
