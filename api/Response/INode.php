<?php
/**
 * Created by Nick Postma.
 * Date: 22-1-14
 * Time: 16:54
 */

namespace Response;

abstract class INode implements IResponse
{
    /**
     * @var \Model\Node
     */
    protected $node;

    /**
     * Constructs a response on a group request
     * @param $node \Model\Node
     */
    function __construct($node)
    {
        $this->node = $node;
    }

    /**
     * Converts a user node into HTML
     * @param \Model\Node $node
     * @return string HTML
     */
    public abstract function convert(\Model\Node $node);
} 