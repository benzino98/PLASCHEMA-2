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

// If config was cached with an empty APP_KEY, remove stale cache so .env is read
$cachedConfig = $corePath.'/bootstrap/cache/config.php';
if (file_exists($cachedConfig)) {
    $configData = @include $cachedConfig;
    if (is_array($configData) && empty($configData['app']['key'])) {
        @unlink($cachedConfig);
    }
}

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $corePath.'/bootstrap/app.php';

// Locate .env in core directory (/home/plaschem/plaschema), parent (/home/plaschem), or public_html
$possibleEnvDirs = [$corePath, dirname($corePath), __DIR__];
$foundEnvPath = null;
foreach ($possibleEnvDirs as $dir) {
    if (file_exists($dir.'/.env')) {
        $foundEnvPath = $dir;
        $app->useEnvironmentPath($dir);
        break;
    }
}

// Set public path to public_html when running outside the core directory
if ($corePath !== __DIR__.'/..') {
    $app->usePublicPath(__DIR__);
}

// Fallback: If APP_KEY is in .env but not yet populated in $_ENV/getenv, set it directly
$hasAppKey = (bool) env('APP_KEY');
if (! $hasAppKey && $foundEnvPath) {
    $envContent = @file_get_contents($foundEnvPath.'/.env');
    if ($envContent && preg_match('/^APP_KEY=([^\s]+)/m', $envContent, $matches)) {
        $extractedKey = trim($matches[1]);
        if (! empty($extractedKey)) {
            putenv("APP_KEY={$extractedKey}");
            $_ENV['APP_KEY'] = $extractedKey;
            $_SERVER['APP_KEY'] = $extractedKey;
            $hasAppKey = true;
        }
    }
}

// If APP_KEY is still missing on production, render a clear diagnostic screen instead of a fatal crash
if (! $hasAppKey && ! app()->runningInConsole() && ! app()->environment('testing')) {
    http_response_code(500);
    header('Content-Type: text/html; charset=utf-8');
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>PLASCHEMA Setup - Missing APP_KEY</title>';
    echo '<style>body{font-family:system-ui,-apple-system,sans-serif;background:#0b1120;color:#f8fafc;padding:2rem;display:flex;justify-content:center;}';
    echo '.box{max-width:680px;background:#1e293b;padding:2rem;border-radius:12px;border:1px solid #334155;box-shadow:0 10px 25px rgba(0,0,0,0.5);}';
    echo 'h1{color:#f43f5e;font-size:1.4rem;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem;}';
    echo 'p{line-height:1.6;color:#cbd5e1;margin-bottom:1rem;}';
    echo 'code,pre{background:#020617;color:#38bdf8;padding:0.2rem 0.4rem;border-radius:4px;font-family:monospace;}';
    echo 'pre{padding:1rem;overflow-x:auto;margin:1rem 0;color:#4ade80;}';
    echo 'ul{margin-left:1.5rem;color:#cbd5e1;line-height:1.8;margin-bottom:1.5rem;}';
    echo '</style></head><body><div class="box">';
    echo '<h1>⚠️ Setup Required: Missing APP_KEY</h1>';
    echo '<p>Your files are deployed successfully, but Laravel requires an <code>APP_KEY</code> in your production <code>.env</code> file to run.</p>';
    echo '<h3>Detected Environment Files:</h3><ul>';
    foreach ($possibleEnvDirs as $dir) {
        $status = file_exists($dir.'/.env') ? '✅ Found' : '❌ Not found';
        echo '<li><code>'.htmlspecialchars($dir.'/.env').'</code>: <strong>'.$status.'</strong></li>';
    }
    if (file_exists($cachedConfig)) {
        echo '<li><code>'.htmlspecialchars($cachedConfig).'</code>: ⚠️ Stale cached config exists (auto-cleared)</li>';
    }
    echo '</ul><h3>How to Fix:</h3>';
    echo '<p>1. In cPanel <strong>File Manager</strong> (enable "Show Hidden Files"), open <code>/home/plaschem/plaschema/.env</code>.<br>';
    echo '2. Add or update the <code>APP_KEY</code> line:</p>';
    echo '<pre>APP_KEY=base64:XPe0cKj7nWrYXklzAcEmStI+VOwdx1cmJtYyCBNjMo8=</pre>';
    echo '<p>3. If <code>/home/plaschem/plaschema/bootstrap/cache/config.php</code> exists, delete it.<br>';
    echo '4. Refresh this page.</p>';
    echo '</div></body></html>';
    exit;
}

$app->handleRequest(Request::capture());
