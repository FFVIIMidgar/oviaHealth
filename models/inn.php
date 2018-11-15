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
private $_profit = 0;
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
/**
 * models/room.php::book() differs from models/inn.php::book() in that
 * $this->book() is entirely concerned with finding the most profitable
 * allocation of guests within the inn. If the room can accommodate a guest at
 * the best available cost then that is where we will put them.
 *
 * Being that this is a shared space inn, guests might be in shared rooms if
 * that’s the most profitable solution.
 *
 * The cost is calculated per person according to this formula:
 * (Base room cost / number of people in the room ) + (base storage costs *
 * number of items stored).
 * Base room cost is 10 Gold, storage cost is 2 Gold.
 *
 */
function book($occupants = 1, $storage = 0)
{
    $loopFlag = false;
    for ($loop = 0;
    $loop < count($this->_rooms);
    $loop++
    ) {
        $room = $this->_rooms[$loop];
        $availibility['occupants'] = $room->_capacity['occupants']
            - $room->_occupancy['occupants'];
        $availibility['storage']   = $room->_capacity['storage']
            - $room->_occupancy['storage'];
        switch (true) {
        case $occupants == $availibility['occupants']
        &&  $storage    == $availibility['storage']:
            if (true === $room->book($occupants, $storage)) {
                // TODO Lets write this booking to the database. It is the best
                // arrangement.
                $this->_profit = (10 * $occupants) + (2 * $storage);
                return true;
            }
            continue;
        case $loopFlag == true
        && $occupants  == $availibility['occupants']
        && $storage < $availibility['storage']:
            if (true === $room->book($occupants, $storage)) {
                // TODO This is not ideal profitability, but definitely the next
                // best thing. Lets go for it.
                $this->_profit = (10 * $occupants) + (2 * $storage);
                return true;
            }
        }
        /*
         * We can puzzle over this forever if we want to, but we really only
         * need to loop twice to consider whether we can:
         *
         * 1) accommodate the guests and exactly their luggage, or
         * 2) accommodate the guests with some room to spare for their luggage
         *
         * There is no need to think any further if we can not physically
         * accommodate the guests, and we can not separate them from their
         * luggage so this loop is fairly simple. We just run through twice to
         * check availability.
         */
        if ($loopFlag == false
        &&  $loop == count($this->_rooms) - 1
        ) {
            $loop     = 0;
            $loopFlag = true;
        }
    }
}
}
