<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FleetModel extends CSV_Model
{

    // Constructor
    public function __construct()
    {
        parent::__construct(APPPATH . DATAPATH.'fleet.csv', 'id');
    }
    
    // retrieve a single plane, null if not found
//    public function get($which);

    // retrieve all of the planes
//    public function all();
}
