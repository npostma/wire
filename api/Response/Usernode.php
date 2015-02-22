<?php
/**
 * THIS IS A EXAMPLE CONTROLLER FOR THE DEMO VIEW AND CAN BE REMOVED
 * Created by Nick Postma.
 * Date: 17-1-14
 * Time: 15:27
 */

namespace Response;

/**
 * Class for retrieving and showing an usernode
 * Class View
 */
final class Usernode extends INode
{

    /**
     * Executes the response
     * @return mixed
     */
    public function execute()
    {
        echo $this->convert($this->node);
    }

    /**
     * Converts a user node into HTML
     * @param \Model\Node $node
     * @return string HTML
     */
    public function convert(\Model\Node $node)
    {
        return '
            <li
                class="leaf"
                data-name="' . $node->getName() . '"
                data-description="' . $node->getDescription() . '"
                data-nodeid="' . $node->getId() . '"
            >
                <a class="user">' . $node->getName() . '</a>
            </li>
        ';
    }
}