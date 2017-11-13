<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * The Plane entity class. The base class of all plane instances.
 */
class Plane extends Entity {
    private $id = NULL;
    private $model_id = NULL;
    
    /**
     * Sets Plane Id of the Fleet.
     * @param type $value
     */
    public function setPlane($value) {
        $this->id = $value;
    }
    
    /**
     * Sets Plane Model Id.
     * @param type $value
     */
    public function setDepart($value) {
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

