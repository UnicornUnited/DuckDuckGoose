<?php
class FlightModel extends CI_Model
{

    // The data is hardcoded to indicate the flights we've created.
    // Flight_ID	Plane Type                     Depart Airport	  Depart Airport Name                  Time	                  Arrival Airport	Arrival Airport Name                                Time
    var $data = array(
        'G100' => array('plane' => 'Grand Caravan EX','depart' => 'YGE', 'depart_airport' => 'Golden Airport' ,'depart_time' => '08:00', 'arrival' => 'ZMH', 'arrival_airport' => 'South Cariboo Regional Airport','arrival_time' => '09:00'),
        'G200' => array('plane' => 'Grand Caravan EX','depart' => 'ZMH', 'depart_airport' => 'South Cariboo Regional Airport','depart_time' => '09:30', 'arrival' => 'YGE', 'arrival_airport' => 'Golden Airport','arrival_time' => '10:30'),
        'G300' => array('plane' => 'Grand Caravan EX','depart' => 'YGE', 'depart_airport' => 'Golden Airport','depart_time' => '11:00', 'arrival' => 'ZMH', 'arrival_airport' => 'South Cariboo Regional Airport','arrival_time' => '12:00'),
        'G400' => array('plane' => 'Grand Caravan EX','depart' => 'ZMH', 'depart_airport' => 'South Cariboo Regional Airport','depart_time' => '12:30', 'arrival' => 'YGE', 'arrival_airport' => 'Golden Airport','arrival_time' => '13:30'),
        'G500' => array('plane' => 'PC-12 NG','depart' => 'YGE', 'depart_airport' => 'Golden Airport','depart_time' => '08:30', 'arrival' => 'YYJ', 'arrival_airport' => 'Victoria International Airport','arrival_time' => '10:00'),
        'G600' => array('plane' => 'PC-12 NG','depart' => 'YYJ', 'depart_airport' => 'Victoria International Airport','depart_time' => '10:30', 'arrival' => 'YGE', 'arrival_airport' => 'Golden Airport','arrival_time' => '12:00'),
        'G700' => array('plane' => 'PC-12 NG','depart' => 'YGE', 'depart_airport' => 'Golden Airport','depart_time' => '13:00', 'arrival' => 'YYJ', 'arrival_airport' => 'Victoria International Airport','arrival_time' => '14:30'),
        'G800' => array('plane' => 'PC-12 NG','depart' => 'YYJ', 'depart_airport' => 'Victoria International Airport','depart_time' => '15:00', 'arrival' => 'YGE', 'arrival_airport' => 'Golden Airport','arrival_time' => '16:30'),
        'G900' => array('plane' => 'Phenom 100','depart' => 'YGE', 'depart_airport' => 'Golden Airport','depart_time' => '17:00', 'arrival' => 'YVE', 'arrival_airport' => 'Vernon Regional Airport','arrival_time' => '17:30'),
        'G1000' => array('plane' => 'Phenom 100','depart' => 'YVE', 'depart_airport' => 'Vernon Regional Airport','depart_time' => '18:00', 'arrival' => 'YGE', 'arrival_airport' => 'Golden Airport','arrival_time' => '18:30'),
        'G1100' => array('plane' => 'Phenom 100','depart' => 'YGE', 'depart_airport' => 'Golden Airport','depart_time' => '19:00', 'arrival' => 'YVE', 'arrival_airport' => 'Vernon Regional Airport','arrival_time' => '19:30'),
        'G1200' => array('plane' => 'Phenom 100','depart' => 'YVE', 'depart_airport' => 'Vernon Regional Airport','depart_time' => '20:00', 'arrival' => 'YGE', 'arrival_airport' => 'Golden Airport','arrival_time' => '20:30'),
    );

    // Constructor
    public function __construct()
    {
        parent::__construct();

        // inject each "record" key into the record itself, for ease of presentation
        foreach ($this->data as $key => $record)
        {
            $record['key'] = $key;
            $this->data[$key] = $record;
        }
    }

    // retrieve a single flight, null if not found
    public function get($which)
    {
        return !isset($this->data[$which]) ? null : $this->data[$which];
    }

    // retrieve all of the scheduled flights
    public function all()
    {
        return $this->data;
    }

}
