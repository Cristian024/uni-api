<?php

namespace App;

require_once __DIR__ . '/../config/imports.php';
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\General\ServerController;
use App\Routes\Routes;
use App\Services\Router;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

ServerController::validateCorrectPetition();

parse_str($_SERVER['QUERY_STRING'], $params);
$method = $_SERVER['REQUEST_METHOD'];

header("Content-type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");

$path = isset ($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$idExplode = explode('/', $path);
$queryId = ($path !== '/') ? end($idExplode) : null;

new Routes();

Router::dispatch($method, $params['route']);


