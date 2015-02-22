<?php
/**
 * Created by Nick Postma.
 * Date: 16-1-14
 * Time: 20:01
 */

namespace Route;

/**
 * Abstract class for uri handling (routes) through the application
 * Class Handle
 * @package Route
 */
abstract class Handle {

    /**
     * The requested URI
     * @var string
     */
    protected $uri;

    /**
     * @param $uri string sets the uri
     */
    public function setUri($uri) {
        $this->uri = $uri;
    }

    /**
     * @return string gets the uri
     */
    public function getUri() {
        return $this->uri;
    }

    /**
     * @return mixed function for calling the correct program code according to implementation
     */
    public abstract function call();
} 