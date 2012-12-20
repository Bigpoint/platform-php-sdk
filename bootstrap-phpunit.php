<?php

require_once 'PHPUnit/Framework/TestCase.php';

spl_autoload_register(
    function ($class) {
        $class = str_replace('Bigpoint\\', '', $class);
        include 'src/' . $class . '.php';
    }
);
