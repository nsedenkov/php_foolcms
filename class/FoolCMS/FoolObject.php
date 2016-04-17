<?php
namespace FoolCMS;

abstract class FoolObject implements IObject {
    //Паттерн Фабрика
    public static function initial($type) {
        $cname = __NAMESPACE__ . "\\" . ucfirst(strtolower($type));
        return new $cname();
    }

    //abstract function loadObject($id);
}

?>
