<?php

require_once 'PHPUnit/Autoload.php';

spl_autoload_register(
    function ($class) {
        $class = str_replace('Bigpoint\\', '', $class);
        $file = 'src/' . $class . '.php';
        if (true === file_exists($file)) {
            include $file;
            return;
        }
        $file = $class . '.php';
        if (true === file_exists($file)) {
            include $file;
        }
    }
);
