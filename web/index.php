<?php 
namespace Wambo;

use Wambo\Core\App;

error_reporting(E_ALL);
ini_set('display_errors', 1);

// define root directory for the project
define('WAMBO_ROOT_DIR', dirname(getcwd() . '..'));

// load autoload file generated by composer
$autoload_filename = WAMBO_ROOT_DIR . '/vendor/autoload.php';
if (!file_exists($autoload_filename)) {
    echo $autoload_filename . " was not found";
    exit(1);
}

require_once $autoload_filename;

$config = require WAMBO_ROOT_DIR . '/src/config.php';
$app = new App($config);

$app->registerPackage( new Cms\Registreation() );
$app->registerPackage( new UrlRewrite\Registration() );

$app->run();
