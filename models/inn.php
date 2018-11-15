<?php
/**
 * inn object model
 * PHP version 5
 *
 * @category oviaHealthTest
 * @package inn
 * @author   Jonathan Smalls <jonathan.smalls@noaa.gov>
 * @version  "GIT: <git_id>"
 * @link     https://github.com/anEffingChamp/oviaHealth
 */
class inn
{
/**
 * private property $_rooms contains the state of each of the four rooms of the
 * inn. They are numerically indexed from zero within this array.
 */
private $_rooms = array();
function __construct()
{
    include_once room.php;
    $this->_rooms[] = new room(2, 1);
    $this->_rooms[] = new room(2, 0);
    $this->_rooms[] = new room(1, 2);
    $this->_rooms[] = new room(1, 0);
}
}
