<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Locate core path: sibling '../plaschema' on shared hosting (outside public_html), or parent '../'
$corePath = is_dir(__DIR__.'/../plaschema') ? __DIR__.'/../plaschema' : __DIR__.'/..';

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $corePath.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $corePath.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $corePath.'/bootstrap/app.php';

// Set public path to public_html when running outside the core directory
if ($corePath !== __DIR__.'/..') {
    $app->usePublicPath(__DIR__);
}

$app->handleRequest(Request::capture());

