<?php
/**
 * Created by Nick Postma.
 * Date: 17-1-14
 * Time: 15:27
 */

namespace Response;


/**
 * Class for retrieving and showing Json
 * Class View
 */
final class Json implements IResponse
{
    private $data;

    /**
     * Give any data for encoding
     * @param $data Mixed
     */
    function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Executes the response (translates the data to a Json encoded string
     * @return void
     */
    public function execute()
    {
        echo json_encode($this->data);
    }
}