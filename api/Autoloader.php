<?php
/**
 * Created by Nick Postma.
 * Date: 16-1-14
 * Time: 20:27
 */

/**
 * Class for finding the correct class definitions and load them.
 * Class Autoloader
 */
class Autoloader {

    /**
     * @var Autoloader
     */
    public static $instance;

    /**
     * @return Autoloader
     */
    public static function getInstance()
    {
        if (self::$instance == NULL) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Register the autoloader in the system
     */
    private function __construct()
    {
        spl_autoload_register(array($this,'api'));
    }

    /**
     * Finds API class definitions and includes them
     * @param $class
     */
    public function api($class) {

        # Translate namespace paths to OS dependant FS paths
        $fsClass = str_replace('\\', DIRECTORY_SEPARATOR, $class);

        # Standard autoloader doesnt seem to work on PHP 5.3 linux server with namespaces.
        # This works local on my PHP 5.4 windows server ... probably something with namespace slashes and FS slashes
        if(IS_DEV) {
            $allPaths = get_include_path() . PATH_SEPARATOR . PATH_API;
            set_include_path($allPaths);
            spl_autoload_extensions('.php');
            spl_autoload($fsClass);
        } else {

            $fullPath = PATH_API . $fsClass . '.php';

            if(file_exists($fullPath)) {
                require($fullPath);
            } else {
               throw new Exception('Could not find the file: ' . $fullPath);
            }
        }
    }
}