<?php
namespace FoolCMS;

class ObjRegistry {
    // Паттерн Singleton registry
    // Использование:
    // foreach (ObjRegistry::getInstance->get("post") as $postid) ...
    private static $instance = null;
    private static $types = array("post", "plugin", "widget");
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
            self::$instance->fill();
        }
        return self::$instance;
    }

    private function fill(){
        foreach(self::$types as $type) {
            $res = Dbaccess::getInstance()->getAllObjects($type);
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

?>
