<?php
/**
 * Created by Nick Postma.
 * Date: 18-1-14
 * Time: 14:59
 */

namespace Response\Gui;

/**
 * HTML parser
 * Interface Parser
 * @package Response\Gui
 */
class HtmlParser extends Parser {

    /**
     * Parse the given content
     * @return string HTML
     */
    public function parse() {
        # Replace al the HTML content between {{ }} for its result.
        $html = preg_replace_callback
            ('/{{(.*)}}/',
            function($match) {
                ob_start();
                eval('echo ' . $match[1] . ';');
                $output = ob_get_clean();
                return $output;
            },
            $this->content
        );
        return $html;
    }


}