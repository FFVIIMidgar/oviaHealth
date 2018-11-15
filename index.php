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
    echo "This is the endpoint for inn management. Available functions are:
        - getAvailability()
        - bookRoom()
        - scheduleCleaning()\n";
}
/*
 * Based on guests bookings, luggage storage requirements and cleaning
 * availability
 */
function getAvailability()
{
    return $this->_availability;
}
/**
 * Has an endpoint for booking rooms
 * Based on guests bookings, luggage storage requirements and cleaning
 * availability this should return a valid room number, to confirm the booking
 * or an error if the room is not bookable for some reason.
 */
function bookRoom($occupants, $storage)
{
    return $this->_inn->book($occupants, $storage);
}
}
$index = new innController;
$index->index();
