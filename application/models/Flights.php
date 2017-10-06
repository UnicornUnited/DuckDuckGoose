<?php
class Flights extends CI_Model
{

    // The data is hardcoded to indicate the flights we've created.
    // Flight_ID	Depart Airport	Time	Arrival Airport	Time	Flight Time Hours
    var $data = array(
        'G100' => array('depart' => 'YGE', 'depart_time' => '08:00', 'arrival' => 'ZMH', 'arrival_time' => '09:00'),
        'G200' => array('depart' => 'ZMH', 'depart_time' => '09:30', 'arrival' => 'YGE', 'arrival_time' => '10:30'),
        'G300' => array('depart' => 'YGE', 'depart_time' => '11:00', 'arrival' => 'ZMH', 'arrival_time' => '12:00'),
        'G400' => array('depart' => 'ZMH', 'depart_time' => '12:30', 'arrival' => 'YGE', 'arrival_time' => '13:30'),
        'G500' => array('depart' => 'YGE', 'depart_time' => '08:30', 'arrival' => 'YYJ', 'arrival_time' => '10:00'),
        'G600' => array('depart' => 'YYJ', 'depart_time' => '10:30', 'arrival' => 'YGE', 'arrival_time' => '12:00'),
        'G700' => array('depart' => 'YGE', 'depart_time' => '13:00', 'arrival' => 'YYJ', 'arrival_time' => '14:30'),
        'G800' => array('depart' => 'YYJ', 'depart_time' => '15:00', 'arrival' => 'YGE', 'arrival_time' => '16:30'),
        'G900' => array('depart' => 'YGE', 'depart_time' => '17:00', 'arrival' => 'YVE', 'arrival_time' => '17:30'),
        'G1000' => array('depart' => 'YVE', 'depart_time' => '18:00', 'arrival' => 'YGE', 'arrival_time' => '18:30'),
        'G1100' => array('depart' => 'YGE', 'depart_time' => '19:00', 'arrival' => 'YVE', 'arrival_time' => '19:30'),
        'G1200' => array('depart' => 'YVE', 'depart_time' => '20:00', 'arrival' => 'YGE', 'arrival_time' => '20:30'),
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
