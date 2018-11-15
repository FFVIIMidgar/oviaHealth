
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
private $_occupancy = 2;
private $_storage   = 0;
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
    }
    $this->_occupancy = $occupancy;
    $this->_storage   = $storage;
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
    $this->_clean = time() + (3600 + (1800 * $this->_occupancy));
    return $this->_clean;
}
}
