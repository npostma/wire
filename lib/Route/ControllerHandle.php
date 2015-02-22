<?php
/**
 * Created by Nick Postma.
 * Date: 16-1-14
 * Time: 20:01
 */

namespace Route;

use Controller\Error;
use Response\IResponse;

/**
 * Class for translating Uri's to controller calls
 * Class ControlerHandle
 * @package Route
 */
final class ControllerHandle extends  Handle{

    /**
     * Name of the controler to call
     * @var string
     */
    private $controlerName = '';

    /**
     * Function to call, not set? Then the index will be called
     * If it is a GET request it will be getIndex, if it is a POST request then it will be postIndex
     * @var string
     */
    private $controlerFunction = '';

    /**
     * Collection of parameters. The function will be called with these parameters
     * @var array
     */
    private $controlerParams = array();

    /**
     * Dissects the uri data into parts that call will use
     */
    private function dissect() {
        # Seperate uri from its get params;
        $uriParts = explode('?', $this->uri);

        # If last char is a / then remove it.
        $indexLastChar = strlen($uriParts[0]) - 1;
        if($indexLastChar > 0 && $uriParts[0][$indexLastChar] == '/') {
            $uriParts[0] = substr($uriParts[0], 0, $indexLastChar);
        }

        $data = explode('/', $uriParts[0]);

        # Count if enough data is available,
        # Todo: Define Index and Home in a settings file/class
        $numParts = count($data);
        if($numParts == 1) {
            if(empty($data[0])) {
                $numParts = 0;
                unset($data[0]);
            } else {
                $data[] = 'index';
            }
        }


        # No parts? Open the standard controller
        # otherwise assemble the controller and check its existence. If not: open the error page
        if($numParts == 0) {
            $data[] = 'home';
            $data[] = 'index';
        } else if(!file_exists(PATH_API . 'Controller' . DIRECTORY_SEPARATOR  . ucfirst($data[0]) . '.php')) {
            $data[0] = 'error';
            $data[1] = 'index';
            $data[2] = '404';
        }
        $this->controlerName = array_shift($data);
        $this->controlerFunction = array_shift($data);
        $this->controlerParams = $data;
    }

    /**
     * Call the correct controller and function
     * @return IResponse
     */
    public function call() {
        $this->dissect();

        # Concat controller namespace with classname
        $controlerName = 'Controller\\'  . ucfirst($this->controlerName);

        # Make function name and determine if the request is a GET or POST request. Default is GET
        $controlerFunction = 'get' . ucfirst($this->controlerFunction);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controlerFunction = 'post' . ucfirst($this->controlerFunction);
        }

        # Make controller object
        $controler = new $controlerName();

        # If the method doesn't exists call the error page
        if(!method_exists($controler, $controlerFunction)) {
            $controler = new Error();
            $controlerFunction = 'getIndex';
            $this->controlerParams = array('error', 404);
        }

        # Call function
        return call_user_func_array(array($controler, $controlerFunction), $this->controlerParams);
    }
} 