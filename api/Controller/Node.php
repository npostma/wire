<?php
/**
 * Created by Nick Postma.
 * Date: 16-1-14
 * Time: 20:11
 */

namespace Controller;

use Response\Gui\View;
use Response\Json;
use Response\Usernode;
use Response\Groupnode;

/**
 * Default controller
 * Class Home
 * @package Controller
 */
class Node implements IController {

    /**
     * Main application HTML
     * @return View
     */
    public function getIndex() {
        throw new \Exception('Please implement and return a view');
    }

    /**
     * Translates the GET data into a json encoded string
     * @return Json
     */
    public function getContents() {
        # Keep track of the last ID so that er is an auto increment number for new nodes.
        $_SESSION['node']['selectedId'] = $_GET['nodeId'];
        if(!isset($_SESSION['node']['highestId'])) {
            $_SESSION['node']['highestId']  = $_GET['nodeId'];

            # First time click event is on the root node.
            $node = new \Data\Node();
            $node->setName($_GET['name']);
            $node->setId($_GET['nodeId']);
            $node->setDescription($_GET['description']);
            $node->setType(\Data\Node::TYPE_GROUP);
            \Data\Tree::getInstance()->setRoot($node);

        } else {
            $_SESSION['node']['highestId'] = ($_GET['nodeId'] > $_SESSION['node']['highestId'] ? $_GET['nodeId'] : $_SESSION['node']['highestId']);
        }

        $json = new Json($_GET);
        return $json;
    }

    /**
     * Translates the POST data into a json encoded string
     * @return Json
     */
    public function postContents() {
        # Update node in tree, if it is not the root
        if($_POST['nodeId'] > 1) {
            $node = \Data\Tree::getInstance()->find($_POST['nodeId']);
            $node->setName($_POST['name']);
            $node->setDescription($_POST['description']);
            \Data\Tree::getInstance()->addNode($node->getParentId(), $node);
        }

        # Returning data
        $json = new Json($_POST);
        return $json;
    }

    /**
     * Processes the post of a new node
     */
    public function postAdd() {
        $parentNodeId = $_POST['parentNodeId'];

        # Create a child node
        $node = new \Data\Node();
        $node->setName($_POST['name']);
        $node->setId(++$_SESSION['node']['highestId']);
        $node->setDescription($_POST['description']);
        $node->setType($_POST['nodeType']);

        # Add the node to the tree
        \Data\Tree::getInstance()->addNode($parentNodeId, $node);

        switch($_POST['nodeType']) {
            case \Data\Node::TYPE_USER:
                $response = new Usernode($node);
                break;
            case \Data\Node::TYPE_GROUP:
                $response = new Groupnode($node);
                break;
        }
        return $response;
    }

    /**
     * Remove an element from the tree
     */
    public function postDelete() {
        \Data\Tree::getInstance()->deleteNode($_POST['nodeId']);

        # Returning data
        $json = new Json($_POST);
        return $json;
    }
}