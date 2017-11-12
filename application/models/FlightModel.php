<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FlightModel extends CSV_Model
{

    // Constructor
    public function __construct()
    {
        parent::__construct(APPPATH . DATAPATH.'flight.csv', 'id');
    }
    
    /**
     * Save an entity to data file
     * @param type $entity
     */
    public function saveFlight($entity){
        
    }
    
    /**
     * Save a collection of entity to data file
     * @param type $collection an array of entity
     */
    public function saveFlightCollection($collection){
        
    }
    
}
