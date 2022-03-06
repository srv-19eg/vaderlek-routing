<?php
require_once "../vendor/autoload.php";

use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter;

define('ROOT', dirname(__DIR__));

require_once ROOT . '/routes/routes.php';
require_once ROOT . '/App/functions.php';

SimpleRouter::setDefaultNamespace('\App\Controllers');

SimpleRouter::error(function (Request $request, \Exception $exception) {

    switch ($exception->getCode()) {
        // Page not found
        case 404:
            echo "404";
            exit();
        // Forbidden
        case 403:
            echo "403";
            exit();
    }

});
SimpleRouter::start();

