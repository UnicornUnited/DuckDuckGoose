<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * The Flight entity class. The base class of all flight instances.
 */
class Flight extends Entity {
    private $id = NULL;
    private $plane = NULL;
    private $depart_time = NULL;
    private $depart = NULL;
    private $arrive_time = NULL;
    private $arrive = NULL;
    
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
}

