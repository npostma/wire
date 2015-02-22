<?php
/**
 * Created by Nick Postma.
 * Date: 17-1-14
 * Time: 15:27
 */

namespace Response;


/**
 * Class for retrieving and showing html
 * Class View
 */
final class Html implements IResponse
{
    private $data;

    /**
     * Give any data for display
     * @param $data Mixed
     */
    function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Executes the response (translates the data to a humanized readable content)
     * @return void
     */
    public function execute()
    {
        if (is_array($this->data) || is_object($this->data)) {
            echo \Data\Inspect::collection($this->data);
        } else {
            echo $this->data;
        }
    }
}