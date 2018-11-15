<?php
/**
 * booking system controller
 * PHP version 5
 *
 * @category oviaHealthTest
 * @package inn
 * @author   Jonathan Smalls <jonathan.smalls@noaa.gov>
 * @version  "GIT: <git_id>"
 * @link     https://github.com/anEffingChamp/oviaHealth
 */
class innController
{
private $_inn;
protected $_availability = array();
function __construct()
{
    include_once 'models/inn.php';
    $this->_inn = new inn;
    $rooms = $this->_inn->getRooms();
    foreach ($rooms as $room) {
        $this->_availability[] = $room->getCapacity();
    }
}
function index()
{
}
function getAvailability()
{
    return $this->_availability;
}
}
$index = new innController;
$index->index();
