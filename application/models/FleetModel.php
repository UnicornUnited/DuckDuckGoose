<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FleetModel extends CSV_Model
{

    // Constructor
    public function __construct()
    {
        parent::__construct(APPPATH . DATAPATH.'fleet.csv', 'id');
    }
    
    /**
     * Save an entity to data file
     * @param type $entity
     */
    public function saveFleet($entity){
        
    }
}
