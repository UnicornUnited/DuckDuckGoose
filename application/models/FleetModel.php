<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FleetModel extends CSV_Model
{
    private $budget = 10000000;
    private $plane_types = null;

    // Constructor
    public function __construct()
    {
        parent::__construct(APPPATH . DATAPATH.'fleet.csv', 'id');
    }
    
    /**
     * generate a new id following the naming convention.
     * @return string
     */
    private function generateNewId(){
        return $this->size() + 1;
    }
    
    /**
     * Save an entity to data file
     * @param type $entity
     */
    public function saveFleet($entity){
        //check if entity is an Entity class
        if(!is_a($entity, 'Entity')){
            return false;
        }
        //get the array representation of the entity for saving
        $record = $entity->toArray();
        //add or update?
        if($entity->id === NULL || $this->get($entity->id) === NULL){
            //generate an id for the new record
            $record['id'] = $this->generateNewId();
            $this->add($record);
            return $record['id'];
        }
        else{
            $this->update($record);
            return $record['id'];
        }
    }
    
    /**
     * Save a collection of entity to data file
     * @param type $collection an array of entity
     */
    public function saveFleetCollection($collection){
        //check if collecion is an array of Entity class
        if(!is_array($collection))
            return false;
        foreach ($collection as $entity) {
            if(!is_a($entity, 'Entity')){
                return false;
            }
        }
        //call the saveFlight() to save each entity
        foreach ($collection as $entity) {
            $this->saveFlight($entity);
        }
    }
    
    /**
     * Delete a plane from data file by the reference of given entity
     * @param type $entity an entity to be removed from the data file
     */
    public function deleteFleet($entity){
        //check if entity is an Entity class
        if(!is_a($entity, 'Entity')){
            return false;
        }
        $this->delete($entity->id);
        return $this->get($entity->id) === NULL;
    }
    
    // provide form validation rules
    public function rules()
    {
        $config = array(
            ['field' => 'model_id', 'label' => 'Model Id', 'rules' => 'required'],
        );
            return $config;
    }
    
    /**
     * Retrieve the total budget allocated to this fleet.
     * @return type double
     */
    public function getBudget(){
        return doubleval($this->budget);
    }
    
    /**
     * Return how much money has been spent in buying planes for this fleet.
     * @return type double
     */
    public function getGrandTotal(){
        $wackyModel = new WackyModel();
        $planes_raw = $wackyModel->airplanes();
        $planes = array();
        foreach($planes_raw as $key=>$plane){
            $planes[$plane['id']] = $plane;
        }
        $grandTotal = 0.0;
        foreach ($this->all() as $key => $value) {
            $grandTotal += doubleval($planes[$value->model_id]['price']);
        }
        return $grandTotal;
    }
    
    /**
     * Check if the given plane type is valid
     * @param type $type
     */
    public function checkPlaneType($type){
        if($this->plane_types == null){
            $wackyModel = new WackyModel();
            $planes = $wackyModel->airplanes();
            $this->plane_types = array();
            foreach ($planes as $key => $plane) {
                $this->plane_types[$plane['id']] = $plane['id'];
            }
            return in_array($type, $this->plane_types);
        }
    }
    
    /**
     * A set of rules for form validation.
     */
    public function formRules(){
        //Form Validation from Codeigniter helper
        $config = array(
            ['field' => 'plane_id', 'label' => 'Plane Id', 'rules' => 'alpha_numeric|greater_than[0]'],
            ['field' => 'model_id', 'label' => 'Model', 'rules' => 'required|callback_validateModelId'],
        );
        return $config;
    }
    // retrieve a single plane, null if not found
//    public function get($which);

    // retrieve all of the planes
//    public function all();
}
