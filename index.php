<?php

define('ROOT', __DIR__);

// Выводим все ошибки
error_reporting(E_ALL);
ini_set("display_errors", 1);

require ROOT . '/vendor/autoload.php';

(new \App\Command\DirectionCommand)->run();
