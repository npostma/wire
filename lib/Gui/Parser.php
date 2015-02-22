<?php
/**
 * Created by Nick Postma.
 * Date: 18-1-14
 * Time: 14:59
 */

namespace Gui;

/**
 * Basic class for a parser
 * Interface Parser
 * @package Gui
 */
abstract class Parser {
    /**
     * @var mixed
     */
    protected $content;

    /**
     * Sets the raw, un-parsed data
     * @param $content mixed data
     */
    public function setContent($content) {
        $this->content = $content;
    }

    /**
     * Retrieves un-parsed content
     * @return mixed
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Parse the given content
     * @return mixed
     */
    public abstract function parse();
}