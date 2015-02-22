<?php
/**
 * THIS IS A EXAMPLE CONTROLLER FOR THE DEMO VIEW AND CAN BE REMOVED
 * Created by Nick Postma.
 * Date: 16-1-14
 * Time: 20:11
 */

namespace Controller;

use Response\Groupnode;
use Response\Html;

/**
 * Default controller. This handles the home page
 * Class Tree
 * @package Controller
 */
class Tree implements IController
{

    /**
     * Main application HTML
     * @return Html
     */
    public function getIndex()
    {
        $response = new \Response\Html(\Data\Tree::getInstance());
        return $response;
    }

    /**
     * @param $id
     * @return \Response\Html
     */
    public function getNode($id = null)
    {
        if ($id == null) {
            # For the demo. Show the difference  between a exception and response
            # throw new \Exception('Please enter a node ID');
            return new \Response\Html('Please enter a node ID');
        }
        $response = new \Response\Html(\Data\Tree::getInstance()->find($id));
        return $response;
    }

    /**
     * @param $id
     * @return \Response\Html
     */
    public function getJson($id = null)
    {
        $response = new \Response\Json(\Data\Tree::getInstance());
        return $response;
    }

    /**
     * Generates the tree into HTML
     * @return \Response\Html
     */
    public function getHtml()
    {
        $root = \Data\Tree::getInstance()->getRoot();
        if (!$root) {
            return new \Response\Html('No data is stored in session');
        }
        $rootHtml = '<ol class="tree">' . Groupnode::build($root) . '</ol>';
        $response = new \Response\Html($rootHtml);
        return $response;
    }

    /**
     * Delete all nodes except the root.
     * @return \Response\Html
     */
    public function postDelete()
    {
        $root = \Data\Tree::getInstance()->getRoot();
        $root->deleteNodes();
        $rootHtml = '<ol class="tree">' . Groupnode::build($root) . '</ol>';
        $response = new \Response\Html($rootHtml);
        return $response;
    }
}