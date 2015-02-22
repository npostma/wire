<?php
/**
 * Created by Nick Postma.
 * Date: 16-1-14
 * Time: 16:35
 */

namespace Data;

/**
 * final Class Inspect
 * Helper class for inspecting variables humanized
 * @package Data
 */
final class Inspect {

    /**
     * Constructor placeholder
     */
    private function __construct() {
    }

    /**
     * View the contents of a variable. Datatype or object. Humanized
     * @param mixed $mixed
     * @return string
     */
    public static function collection($mixed){
        return '<pre>' . print_r($mixed, 1) . '</pre>';
    }
}