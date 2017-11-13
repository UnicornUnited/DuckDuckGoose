<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * The Flight entity class. The base class of all flight instances.
 */
class Flight extends Entity {
    protected $id = NULL;
    protected $model_id = NULL;
    protected $depart = NULL;
    protected $depart_time = NULL;
    protected $arrive = NULL;
    protected $arrive_time = NULL;
    
    private $_initialized = true;

    /**
     * construct the entity using a given data array
     * @param type $data
     */
    function __construct($data = NULL) {
        parent::__construct();
        if($data === NULL) return;
        //initialize properties with checking against the rules
        $this->id = $data['id'];
        if($data['id'] !== NULL && $this->id === NULL) $_initialized = false;
        
        $this->model_id = $data['model_id'];
        if($data['model_id'] !== NULL && $this->model_id === NULL) $_initialized = false;
        
        $this->depart = $data['depart'];
        if($data['depart'] !== NULL && $this->depart === NULL) $_initialized = false;
        
        $this->depart_time = $data['depart_time'];
        if($data['depart_time'] !== NULL && $this->depart_time === NULL) $_initialized = false;
        
        $this->arrive = $data['arrive'];
        if($data['arrive'] !== NULL && $this->arrive === NULL) $_initialized = false;
        
        $this->arrive_time = $data['arrive_time'];
        if($data['arrive_time'] !== NULL && $this->arrive_time === NULL) $_initialized = false;
    }
    
    /**
     * if instantiate this entity with an initialization data array, this
     * function returns the result of validation against the rules (business logics).
     * @return boolean true of false
     */
    public function initialized(){
        return  $this->_initialized;
    }
    
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
    public function setModelId($value) {
        $this->model_id = $value;
    }
    
    /**
     * Sets Departure Airport using ID.
     * @param type $value
     */
    public function setDepart($value) {
        $this->depart_airport = $value;
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
        $this->arriv_time = $value;
    }
    
    /**
     * return an array format representation of this entity
     */
    public function toArray(){
        return array(
            'id'                    => $this->id,
            'model_id'                 => $this->model_id,
            'depart'                => $this->depart,
            'depart_time'           => $this->depart_time,
            'arrive'               => $this->arrive,
            'arrive_time'          => $this->arrive_time
        );
    }
}

