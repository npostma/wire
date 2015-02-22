<?php
/**
 * Created by Nick Postma.
 * Date: 16-1-14
 * Time: 20:11
 */

namespace Controller;

use Response\View;

/**
 * Controller for handling the error pages
 * Class Home
 * @package Controller
 */
class Error implements IController
{
    /**
     * Main function for handling the errors
     * @return View
     * @throws \Exception
     */
    public function getIndex()
    {
        $numAruments = func_num_args();
        if ($numAruments < 1) {
            throw new \Exception('No error code received');
        }

        $arguments = func_get_args();

        $arguments = $arguments[0];
        switch ((int)$arguments) {
            case 404:
                $view = new View('error_404');
                return $view;
            default:
                $view = new View('home');
                return $view;
        }
    }
}