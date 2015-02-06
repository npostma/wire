<?php
/**
 * Created by Nick Postma.
 * Date: 16-1-14
 * Time: 16:36
 */

/**
 * Namespaces
 */
use Datatype\Inspect;
use Uri\Resolve;
use Route\ControllerHandle;

/**
 * Defining application constants
 */
define("PATH_PUBLIC", __DIR__ . DIRECTORY_SEPARATOR);
define("PATH_ROOT", str_replace(DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR, '', PATH_PUBLIC) . DIRECTORY_SEPARATOR  );
define("PATH_API", PATH_ROOT . "api" . DIRECTORY_SEPARATOR);
define("IS_DEV", ($_SERVER['HTTP_HOST'] == '127.0.0.1'));

/**
 * Setting up the system's autoloader
 * The only manual include
 */
include_once(PATH_API . 'Autoloader.php');
$classAutoLoader = Autoloader::getInstance();

/**
 * Starting the session for persisted data storage (server side)
 * Do NOT put this before the autoloader. Otherwise object get corrupted in the session.
 */
session_start();

$resolve = Resolve::getInstance();
$uri = $resolve->uri();

$controllerHandle = new ControllerHandle();
$controllerHandle->setUri($uri);
$response = $controllerHandle->call();
$response->execute();