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
 *
 * The inn has FOUR rooms
 *
 * ONE room sleeps TWO people and has ONE storage space
 * ONE room sleeps TWO people and has ZERO storage space
 * ONE room has TWO storage spaces and sleeps ONE person
 * ONE room sleeps ONE person and has ZERO storage space
 */
private $_rooms = array();
/*
 * $this->_cleaningTeam keeps track of how many hours the cleaning gnomes have
 * worked today.
 *
 * There is only ONE gnome cleaning squad, but we might hire more.
 * Legally the gnomes are only allowed to work EIGHT hours per day, but we’re
 * always lobbying the local lord to let the gnomes work more. ( We’re really
 * sure they want to )
 * The gnomes start time is flexible but must be contiguous.
 */
private $_cleaningTeam = array(
    'timeStart' => 0,
    'room'      => 0,
    'timeClean' => 0
);
function __construct()
{
    include_once room.php;
    /*
     * We initialize each of the four rooms in the inn.
     */
    $this->_rooms[] = new room(2, 1);
    $this->_rooms[] = new room(2, 0);
    $this->_rooms[] = new room(1, 2);
    $this->_rooms[] = new room(1, 0);
    /*
     * Then we can schedule an appropriate start time for the cleaning team.
     */
    $this->_cleaningTeam['timeStart'] = time();
    for ($loop = 0;
    $loop < count($this->_rooms);
    $loop++
    ) {
        /*
         * We check the clean status of each room, or compare the timestamp to
         * verify that they are in fact clean.
         */
        $this->_rooms[$loop]->clean();
    }
}
}
