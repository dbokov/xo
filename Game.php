<?php

namespace dbokov\xo;

class Game
{

    private static $instance;

    public $field_size = 3;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance()
    {

        if(!is_object(self::$instance))
        {
            self::$instance = new self();
        }

        return self::$instance;
    }


}