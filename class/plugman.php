<?php

interface IObject {
    public function __construct($id);
    private function loadObject();
}

abstract class FoolObject implements IObject {
    private $objid;
    public function __construct($id) {
        $this->objid = $id;
    }

    private function loadObject() {

    }
}

class Plugin extends FoolObject {

}

class Post extends FoolObject {

}

class PlugManager {

    private static $instance;
    private $plugins = array();

    private function __construct() {
        self::scanPlugins();
    }

    public static function getInstance(){
        if(empty(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function scanPlugins() {

    }
}

?>
