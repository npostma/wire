<?php
/**
 * Created by Nick Postma.
 * Date: 17-1-14
 * Time: 15:27
 */

namespace Response;

/**
 * Class for retrieving and showing a group node
 * Class View
 */
final class Groupnode extends INode {

    /**
     * Executes the response
     * @return mixed
     */
    public function execute()
    {
        echo Groupnode::convert($this->node);
    }

    /**
     * Converts a user node into HTML
     * @param \Data\Node $node
     * @return string HTML
     */
    public function convert(\Data\Node $node)
    {
        return Groupnode::header($node) . Groupnode::footer();
    }

    /**
     * Generates the header part of the groupnode
     * @param \Data\Node $node
     * @return string
     */
    private static function header(\Data\Node $node) {
        return '<li>
                <label
                    data-name="' . $node->getName() .  '"
                    data-description="' . $node->getDescription() .  '"
                    data-nodeid="' . $node->getId() .  '"
                >
                    ' . $node->getName() .  '
                </label>
                <input type="checkbox" />
                <ol>';
    }

    /**
     * Generates the footer part of the groupnode
     * @return string
     */
    private static function footer() {
        return  '</ol></li>';
    }

    /**
     * Builds the tree from A groupnode down to the last nodes
     * @param \Data\Node $node
     * @return string
     */
    public static function build(\Data\Node $node) {
        $html = Groupnode::header($node);
        /* @var $childNode Node */
        foreach($node->getChildren() AS $childNode) {
            if($childNode->getType() == \Data\Node::TYPE_GROUP) {
                $html .= Groupnode::build($childNode);
            } else if($childNode->getType() == \Data\Node::TYPE_USER) {
                $Usernode = new Usernode($childNode);
                $html .= $Usernode->convert($childNode);
            }
        }
        $html .= Groupnode::footer($node);
        return $html;
    }
}