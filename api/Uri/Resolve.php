<?php
/**
 * Created by Nick Postma.
 * Date: 16-1-14
 * Time: 17:08
 */

namespace Uri;

/**
 * Class for resolving the correct path to the controlers
 * Note: $_SERVER['SCRIPT_FILENAME'] will always be /wire/public/index.php and $_SERVER['REQUEST_FILENAME]/$_SERVER['REQUEST_URI''] will be accessible through $_SERVER['REQUEST_URI'].
 * Class Resolve
 * @package Uri
 */
class Resolve {

    /**
     * Defining local constants
     */
    const pathPublic = '/wire/public/';

    /**
     * @var Resolve one instance of Resolve
     */
    private static $instance = null;

    /**
     * Private constructor
     */
    private function __construct() {
    }

    /**
     * Destructor placeholder
     */
    public function __destruct() {
    }

    /**
     * Returns the resource location for the controllers
     * @return string uniform resource identifier
     */
    public function uri() {
        return str_replace(Resolve::pathPublic, '', $_SERVER['REQUEST_URI']);
    }

    /**
     * Returns the root path
     * @return string
     */
    public function root() {
        return Resolve::pathPublic;
    }

    /**
     * Returns the resolve instance
     * @return Resolve
     */
    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;

    }
}