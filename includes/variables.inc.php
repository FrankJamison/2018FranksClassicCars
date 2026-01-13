<?php

// Database Connection Variables
// Base defaults: local development.
// For production, deploy `includes/variables.prod.inc.php` (gitignored)
// or set environment variables (FCC_DB_*).
$host = 'localhost';
$web_user = 'root';
$pwd = '';
$dbname = 'uc_davis_web512';
$dbc = 0;

// Optional local overrides (not committed)
// Create `includes/variables.local.inc.php` to customize without editing this file.
$localVariablesPath = __DIR__ . '/variables.local.inc.php';
if (file_exists($localVariablesPath)) {
    require $localVariablesPath;
}

// Optional production overrides (not committed)
// Create/deploy `includes/variables.prod.inc.php` on production.
// This is loaded when explicitly enabled OR when running on a non-local host.
// (Some hosts/control panels make Apache/PHP env vars hard to set reliably.)
$prodVariablesPath = __DIR__ . '/variables.prod.inc.php';

// Explicit production enable flags (preferred when available)
$useProdConfig = (getenv('FCC_USE_PROD_CONFIG') === '1') || (getenv('FCC_ENV') === 'production');

// Fallback: if the site is running on a non-local hostname and the prod file exists,
// assume production.
$httpHost = '';
if (isset($_SERVER) && is_array($_SERVER)) {
    if (!empty($_SERVER['HTTP_HOST'])) {
        $httpHost = $_SERVER['HTTP_HOST'];
    } elseif (!empty($_SERVER['SERVER_NAME'])) {
        $httpHost = $_SERVER['SERVER_NAME'];
    }
}
// Strip port (example.com:8080)
$hostWithoutPort = $httpHost;
$colonPos = strpos($hostWithoutPort, ':');
if ($colonPos !== false) {
    $hostWithoutPort = substr($hostWithoutPort, 0, $colonPos);
}
$hostLower = strtolower(trim($hostWithoutPort));

$isLocalHost = ($hostLower === '')
    || ($hostLower === 'localhost')
    || ($hostLower === '127.0.0.1')
    || ($hostLower === '::1')
    || (substr($hostLower, -10) === '.localhost');

if (!$useProdConfig && !$isLocalHost && file_exists($prodVariablesPath)) {
    $useProdConfig = true;
}

if ($useProdConfig && file_exists($prodVariablesPath)) {
    require $prodVariablesPath;
}

// Environment variable overrides (useful for production + CI)
$host = getenv('FCC_DB_HOST') ?: $host;
$web_user = getenv('FCC_DB_USER') ?: $web_user;
$pwd = getenv('FCC_DB_PASS') ?: $pwd;
$dbname = getenv('FCC_DB_NAME') ?: $dbname;

// Product Line Variable
$productLine = '';

?>