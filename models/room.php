
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
/**
 * $this->_capacity describes how much a given room can accommodate whereas
 * $this->_occupancy describes how much a given room currently accommodates.
 */
private $_capacity = array(
    'occupants' => 2,
    'storage'   => 0
);
private $_occupancy = array(
    'occupants' => 0,
    'storage' => 0
);
/*
 * $this->_clean marks the time stamp when a room was last cleaned. If that time
 * has elapsed then we can rent the room again.
 */
private $_clean     = 0;
function __construct($occupancy = 2, $storage = 0)
{
    switch (true) {
    /*
     * All rooms accommodate one or two occupants. We limit room objects to one
     * of those two values, and all others are invalid.
     */
    case true === is_numeric($occupancy)
    &&  1 <= $occupancy
    &&  2 >= $occupancy
    /*
     * All of the rooms have either zero to two storage spaces, so we must
     * require that rooms accomodate those binary values. All other inputs are
     * invalid.
     */
    &&  true === is_numeric($storage)
    &&  0 <= $storage
    &&  2 >= $storage:
        break;
    /*
     * There is some problem with the input. Return the error, and let the
     * world handle it.
     */
    default:
        return false;
    }
    $this->$_capacity['occupants'] = $occupancy;
    $this->$_capacity['storage']   = $storage;
    $this->clean();
}
/**
 * clean() estimates the time required after occupancy to clean a room for
 * reuse. Once that time has elapsed we mark $this->_clean = true.
 *
 * All rooms must be cleaned after being occupied and prior to being rented
 * again.
 * The gnomes cleaning squad needs ONE hour per room plus THIRTY minutes per
 * person in the room to clean it.
 */
function clean()
{
    // TODO Presumably we have some form of persistent storage, so we can keep
    // track of whether a room is clean between program runs. For this example I
    // will assume that we have a query() function that already has a database
    // connection, and will return what I need.
    // TODO Is the cleaning time a function of room capacity, or actual room
    // occupants? That is not specified in the problem, but relevant.
    $this->_clean = time() + (3600 + (1800 * $this->$_capacity['occupants']));
    return $this->_clean;
}
/**
 * models/room.php::book() differs from models/inn.php::book() in that
 * $this->book() is entirely concerned with whether the room can physically
 * accommodate a guest.
 *
 * Guests can not store their luggage in another guest’s room.
 */
function book($occupants = 1, $storage = 0)
{
    switch (true) {
    case true      === is_numeric($occupants)
    &&  true       === is_numeric($storage)
    &&  1           <= $occupants
    &&  0           <= $storage
    &&  $occupants  <=
        $this->_capacity['occupants'] - $this->_occupancy['occupants']
    &&  $storage    <=
        $this->_capacity['storage'] - $this->_occupancy['storage']:
        break;
    default:
        return false;
    }
    $this->_occupancy['occupants'] += $occupants;
    $this->_occupancy['storage']   += $storage;
    // TODO Write this object state to persistent storage.
    return true;
}
}
