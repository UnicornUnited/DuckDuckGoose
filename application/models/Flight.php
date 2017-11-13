<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * The Flight entity class. The base class of all flight instances.
 */
class Flight extends Entity {
    protected $id = NULL;
    protected $plane = NULL;
    protected $depart_time = NULL;
    protected $depart = NULL;
    protected $arrive_time = NULL;
    protected $arrive = NULL;
    
    /**
     * Sets Flight Id.
     * @param type $value
     */
    public function setId($value) {
        $this->id = $value;
    }
    
    /**
     * Sets Plane from fleet using ID.
     * @param type $value
     */
    public function setPlane($value) {
        $this->plane = $value;
    }
    
    /**
     * Sets Departure Airport using ID.
     * @param type $value
     */
    public function setDepart($value) {
        $this->depart = $value;
    }
    
    /**
     * Sets Departure Time using 24HR time.
     * @param type $value
     */
    public function setDepartTime($value) {
        $this->depart_time = $value;
    }
    
    /**
     * Sets Arrival Airport using ID.
     * @param type $value
     */
    public function setArrive($value) {
        $this->arrive = $value;
    }
    
    /**
     * Sets Arrival Time using 24HR time.
     * @param type $value
     */
    public function setArriveTime($value) {
        $this->arrive_time = $value;
    }
    
    /**
     * return an array format representation of this entity
     */
    public function toArray(){
        return array(
            'id'                    => $this->id,
            'plane'                 => $this->plane,
            'depart'                => $this->depart,
            'depart_airport'        => $this->depart_airport,
            'depart_time'           => $this->depart_time,
            'arrival'               => $this->arrival,
            'arrival_airport'       => $this->arrival_airport,
            'arrival_time'          => $this->arrival_time,
        );
    }
}

