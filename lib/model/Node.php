<?php
/**
 * Created by Nick Postma.
 * Date: 19-1-14
 * Time: 14:22
 */
namespace Data;

/**
 * A tree node element
 * Class Node
 * @package Data
 */

namespace Model;

class Node {

    /**
     * Defining the node sorts
     */
    const TYPE_NONE = 0;
    const TYPE_GROUP = 1;
    const TYPE_USER = 2;

    /**
     * The unique number of the node
     * @var int
     */
    protected $id = 0;

    /**
     * The name of the node (User or group)
     * @var string
     */
    protected $name = '';

    /**
     * The description of the node (User or group)
     * @var string
     */
    protected $description = '';

    /**
     * Type determines if the node represents a user or a group
     * @var int
     */
    protected $type = Node::TYPE_NONE;

    /**
     * Parent node
     * @var int
     */
    protected $parentId;

    /**
     * The children of the node
     * @var Node
     */
    protected $children = array();

    /**
     * Constructor placeholder
     */
    function __construct() {
    }

    /**
     * Sets the ID of the node
     * @param $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Gets the ID of the node
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Sets the name of the node
     * @param $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Gets the name of the node
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Sets the description
     * @param $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Gets the description of the node
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Sets  the type of the node
     * @param $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * Gets the type of the node
     * @return int
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Sets the parent id
     * @param $parentId int
     */
    public function setParentId($parentId) {
        $this->parentId = $parentId;
    }

    /**
     * Gets the parent id
     * @return int
     */
    public function getParentId() {
        return $this->parentId;
    }

    /**
     * Add a node as a child to this node. If the ID exists, then update the node
     * @param Node $node
     * @return bool Returns true if added, false if updated
     */
    public function addNode(Node $node) {
        # Check if no the same is added twice, then update;
        /* @var $childNode Node */
        foreach($this->children AS &$childNode) {
            if($childNode->getId() == $node->getId()) {
                $childNode = $node;
                return false;
            }
        }
        $this->children[] = $node;
        return true;
    }

    /**
     * Returns a collection of nodes, which are the children of this node
     * @return Node
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * Removes a node from its children. Removing by reference wont work. <x(((---{ PHP BUG
     * @param $nodeId
     */
    public function deleteNode($nodeId) {
        /* @var $childNode Node */
        foreach($this->children AS $index => $childNode) {
            if($childNode->getId() == $nodeId) {
                unset($this->children[$index]);
            } else {
                $childNode->deleteNode($nodeId);
            }
        }
    }

    /**
     * Deletes al the child nodes
     */
    public function deleteNodes() {
        $this->children = array();
    }
}