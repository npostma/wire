<?php
/**
 * Created by Nick Postma.
 * Date: 16-1-14
 * Time: 20:11
 */

namespace Controller;

use Response\View;

/**
 * Default controller. This handles the home page
 * Class Home
 * @package Controller
 */
class Home implements IController
{
    /**
     * Main application HTML
     * @return View
     */
    public function getIndex()
    {
        $view = new View('home');
        return $view;
    }
}