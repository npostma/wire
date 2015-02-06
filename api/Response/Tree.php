<?php
/**
 * Created by Nick Postma.
 * Date: 17-1-14
 * Time: 15:27
 */

namespace Response;

use Response\Gui\HtmlParser;

/**
 * Class for retrieving and showing a group node
 * Class View
 */
final class Tree implements IResponse {

    /**
     * @var \Data\Node
     */
    private $node;

    /**
     * Constructs a html tree response from a specific node
     * @param $node \Data\Node
     */
    function __construct($node) {
        $this->node = $node;
    }

    /**
     * Executes the response
     * @return mixed
     */
    public function execute()
    {
        echo '
             <li>
                <label
                    data-name="' . $this->node->getName() .  '"
                    data-description="' . $this->node->getDescription() .  '"
                    data-nodeid="' . $this->node->getId() .  '"
                >
                    ' . $this->node->getName() .  '
                </label>
                <input type="checkbox" />
                <ol>

                </ol>
                </li>
            ';
    }
}