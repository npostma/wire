<?php
/**
 * Created by Nick Postma.
 * Date: 17-1-14
 * Time: 15:36
 */

namespace Response;

/**
 * Interface for any response that the controller will return
 * Interface IResponse
 * @package Response
 */
interface IResponse
{
    /**
     * Executes the response
     * @return mixed
     */
    public function execute();

}