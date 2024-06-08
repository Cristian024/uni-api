<?php

namespace App;

require_once __DIR__ . '/../config/imports.php';

use App\Controllers\General\ServerController;
use App\Routes\Routes;
use App\Services\Router;

ServerController::validateCorrectPetition();

parse_str($_SERVER['QUERY_STRING'], $params);
$method = $_SERVER['REQUEST_METHOD'];

$path = isset ($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$idExplode = explode('/', $path);
$queryId = ($path !== '/') ? end($idExplode) : null;

new Routes();

Router::dispatch($method, $params['route']);


