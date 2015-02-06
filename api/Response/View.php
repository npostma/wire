<?php
/**
 * Created by Nick Postma.
 * Date: 17-1-14
 * Time: 15:27
 */

namespace Response;

use Response\Gui\HtmlParser;

/**
 * Class for retrieving and showing HTML
 * Class View
 */
final class View implements IResponse {

    /**
     * The extention of a view file
     * @var string
     */
    private $extension;

    /**
     * The path name where the file is located
     * @var string
     */
    private $path;

    /**
     * Name of the file without any extensions
     * @var string
     */
    private $name;

    /**
     * Constructs a response on a view request
     * @param $name string
     */
    function __construct($name) {
        $this->extension = '.view.html';
        $this->path = PATH_PUBLIC . 'views' . DIRECTORY_SEPARATOR;
        $this->name = $name;
    }

    /**
     * Executes the response
     * @return mixed
     */
    public function execute()
    {
        $fullPath = $this->path . $this->name . $this->extension;
        if(!file_exists($fullPath)) {
            throw new \Exception('View not found. Please correct your path.');
        }

        # Starting the object buffer for catching the HTML
        ob_start();
        include_once($fullPath);
        $rawData = ob_get_clean();

        # Parse the content from the output buffer
        $htmlParser = new HtmlParser();
        $htmlParser->setContent($rawData);
        $html = $htmlParser->parse();
        echo $html;
    }
}