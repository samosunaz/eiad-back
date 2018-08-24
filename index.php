<?php
require './vendor/autoload.php';
include './config/bootstrap.php';

header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, Authorization');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Content-Type: application/json; charset=utf-8');

use Slim\App;

$configuration = [
  'settings' => [
    'displayErrorDetails' => true,
  ],
];

$c = new \Slim\Container($configuration);

$app = new App($c);

require './routes/floors.php';
require './routes/labs.php';
require './routes/lab_classes.php';
require './routes/materials.php';
require './routes/reservations.php';
require './routes/roles.php';
require './routes/users.php';

$app->run();