<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FlightModel extends CSV_Model
{

    // Constructor
    public function __construct()
    {
        parent::__construct(APPPATH . DATAPATH.'flight.csv', 'id');
    }
}
