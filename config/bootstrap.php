<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

$capsule = new Capsule();

$capsule->addConnection([
  'driver' => 'mysql',
  'host' => '127.0.0.1',
  'port' => 3306,
  'database' => 'eiad_labs',
  'username' => 'root',
  'password' => 'root',
  'charset' => 'utf8',
  'collation' => 'utf8_general_ci',
  'prefix' => '',
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();