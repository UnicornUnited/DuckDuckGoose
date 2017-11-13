<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * The Plane entity class. The base class of all plane instances.
 */
class Plane extends Entity {
    protected $id = NULL;
    protected $model_id = NULL;
    
    public function __construct($rec = null) {
        parent::__construct();
        
        if (!empty($rec) && is_array($rec))
        {
            $this->setId($rec['id']);
            $this->setModel($rec['model_id']);
        }
    }
    
    /**
     * Sets Plane Id of the Fleet.
     * @param type $value
     */
    public function setId($value) {
        $this->id = $value;
    }
    
    /**
     * Sets Plane Model Id.
     * @param type $value
     */
    public function setModel($value) {
        $this->model_id = $value;
    }

    /**
     * return an array format representation of this entity
     */
    public function toArray(){
        return array(
            'id'                   => $this->id,
            'model_id'             => $this->model_id
        );
    }
}

