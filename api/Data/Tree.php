<?php
/**
 * Created by Nick Postma.
 * Date: 20-1-14
 * Time: 16:23
 */

namespace Data;
//use Controller\Node;

/**
 * A simple unbalanced tree. Worst case searching is O(n)
 * Class Tree
 */
final class Tree {

    /**
     * @var Node
     */
    private $root = null;

    /**
     * Creates an instance of a tree in the session. So it is stored and reused of calls until the browser is closed
     */
    private function __construct() {
    }

    /**
     * Returns the instance of a three. There can only be one in the session.
     * @return Tree
     */
    public static function getInstance() {
        if(!isset($_SESSION['tree']) || $_SESSION['tree'] === null) {
            $_SESSION['tree'] = new Tree();
        }
        return $_SESSION['tree'];
    }

    /**
     * Sets the root node. This can only be done once!
     * @param Node $root
     * @throws \Exception
     */
    public function setRoot(Node $root) {
        if($this->root) {
           throw new \Exception("You cant set the root node twice.");
        }
        $this->root = $root;
    }

    /**
     * Returns the root node of the tree
     * @return null|Node
     */
    public function getRoot() {
        return $this->root;
    }

    /**
     * Adds a node to the tree
     * @param $parentId
     * @param Node $node
     */
    public function addNode($parentId, Node $node) {
        $parentNode = $this->find($parentId);
        $node->setParentId($parentId);
        $parentNode->addNode($node);
    }

    /**
     * Removes a node from the tree by ID
     * @param $nodeId
     */
    public function deleteNode($nodeId) {
        if($this->root) {
            $this->root->deleteNode($nodeId);
        }
        //$_SESSION['tree'] = $this;
    }

    /**
     * Driver function for findInNode (Search for a node with a specific ID in the tree)
     * @param int $nodeId
     * @throws \Exception
     * @return Node|null
     */
    public function find($nodeId) {
        if(!is_numeric($nodeId)) {
            throw new \Exception('Node id must be a number. Got: <pre>' . print_r($nodeId, 1) . '</pre>');
        }
        return $this->findInNode($nodeId, $this->root);
    }

    /**
     * Search for a node with a specific ID in the tree (Recursive, so it can be optimized by making it linear using a buffer)
     * @param int $nodeId
     * @param Node $searchInNode
     * @return Node|null
     */
    private function findInNode($nodeId, Node $searchInNode) {
        if($searchInNode->getId() == $nodeId) {
            return $searchInNode;
        }

        foreach($searchInNode->getChildren() AS $childNode) {
            if($searchInNode->getId() == $nodeId) {
                return $searchInNode;
            } else {
                $result = $this->findInNode($nodeId, $childNode);
                if($result && $result->getId() == $nodeId) {
                    return $result;
                }
            }
        }
        return null;
    }

}