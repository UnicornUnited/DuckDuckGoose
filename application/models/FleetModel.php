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
    
    // provide form validation rules
    public function rules()
    {
        $config = array(
            ['field' => 'task', 'label' => 'TODO task', 'rules' => 'alpha_numeric_spaces|max_length[64]'],
            ['field' => 'priority', 'label' => 'Priority', 'rules' => 'integer|less_than[4]'],
            ['field' => 'size', 'label' => 'Task size', 'rules' => 'integer|less_than[4]'],
            ['field' => 'group', 'label' => 'Task group', 'rules' => 'integer|less_than[5]'],
        );
            return $config;
    }
    // retrieve a single plane, null if not found
//    public function get($which);

    // retrieve all of the planes
//    public function all();
}
