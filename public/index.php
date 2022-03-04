<?php
require_once "../vendor/autoload.php";
use Pecee\SimpleRouter\SimpleRouter;

define('ROOT',dirname(__DIR__));

require_once ROOT.'/routes/routes.php';

SimpleRouter::setDefaultNamespace('\App\Controllers');

SimpleRouter::start();