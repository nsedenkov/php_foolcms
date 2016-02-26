<?php

class PlugManager {

    private static $instance;
    private $plugins = array();

    private function __construct() {
        $this->scanPlugins();
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
