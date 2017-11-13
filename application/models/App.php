<?php

/**
 * Domain-specific lookup tables
 */
class App extends CI_Model
{
//id,planeid,depart,depart_airport,depart_time,arrival,arrival_airport,arrival_time

    // Planes
    private $planeid = [
        1 => 'Grand Caravan Ex',
        2 => 'PC-12 NG',
        3 => 'Phenom 100'
    ];

    // Airport Codes
    private $airportcodes = [
        1	 => 'YVE',
        2	 => 'YGE',
        3	 => 'ZMH',
        4	 => 'YYJ',
        5    => 'ZMH'
    ];


    public function plane($which = null) {
        return isset($which) ?
            (isset($this->planeid[$which]) ? $this->planeid[$which] : 'Unknown') :
            $this->planeid;
    }

    public function airport($which = null) {
        return isset($which) ?
            (isset($this->airportcodes[$which]) ? $this->airportcodes[$which] : 'Unknown') :
            $this->airportcodes;
    }

}
