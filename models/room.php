
<?php
/**
 * room object model
 * PHP version 5
 *
 * @category oviaHealthTest
 * @package room
 * @author   Jonathan Smalls <jonathan.smalls@noaa.gov>
 * @version  "GIT: <git_id>"
 * @link     https://github.com/anEffingChamp/oviaHealth
 */
class room
{
protected $_occupancy = 2;
protected $_storage = 0;
function __construct($occupancy = 2, $storage = 0)
{
    switch (true) {
    /*
     * All rooms accommodate one or two occupants. We limit room objects to one
     * of those two values, and all others are invalid.
     */
    case false === is_numeric($occupancy)
    ||  0       >= $occupancy
    ||  3       <= $occupancy:
    /*
     * All of the rooms have either zero to two storage spaces, so we must
     * require that rooms accomodate those binary values. All other inputs are
     * invalid.
     */
    case false === is_numeric($storage)
    ||  -1      >= $storage
    ||  3       <= $storage:
        /*
         * There is some problem with the input. Return the error, and let the
         * world handle it.
         */
        return false;
    default:
        $this->_occupancy = $occupancy;
        $this->_storage   = $storage;
    }
}
}
