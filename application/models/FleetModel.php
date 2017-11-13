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
}
