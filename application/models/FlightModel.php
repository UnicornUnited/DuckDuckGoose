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
     * generate a new flight id following the naming convention.
     * @return string
     */
    private function generateNewId(){
        return 'G' . (1000 + 10 * $this->size());
    }
    
    /**
     * override the parent functions to return array instead of object
     */
    public function all() {
        $records = parent::all();
        $resource = array();
        foreach ($records as $key => $record) {
            $resource[$key] = (array)$record;
        }
        return $resource;
    }
    
    /**
     * Get the flights that depart from and arrive to airports specified by
     * the user.
     * @param type $dep departure airport
     * @param type $des arrival airport
     */
    public function getFlightsByAirports($departure, $arrival){
        $all = $this->all();
        $flights = array();
        foreach ($all as $flight) {
            if($flight['depart'] == $departure && $flight['arrive'] == $arrival){
                $flights[$flight['id']] = $flight;
            }
        }
        return $flights;
    }
    
    /**
     * Save an entity to data file
     * @param type $entity an entity to be save to the data file
     */
    public function saveFlight($entity){
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
    public function saveFlightCollection($collection){
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
     * Delete an flight from data file by the reference of given entity
     * @param type $entity an entity to be removed from the data file
     */
    public function deleteFlight($entity){
        //check if entity is an Entity class
        if(!is_a($entity, 'Entity')){
            return false;
        }
        $this->delete($entity->id);
        return $this->get($entity->id) === NULL;
    }
    
    /**
     * A set of rules for form validation.
     */
    public function formRules(){
        //Regex for HH:MM format: /^([0-9]|0[0-9]|1[0-9]|2[0-3])?(:([0-5]|[0-5][0-9])?)?$/
        //Built in regex_match[] from form_validation library didn't work. I had to improvise
        //and this seems to be the only way to get the regex to work
        function my_func ($field) {
            return (bool)preg_match('/^([0-9]|0[0-9]|1[0-9]|2[0-3])?(:([0-5]|[0-5][0-9])?)?$/', $field);
        }

        //Form Validation from Codeigniter helper
        $config = array(
                ['field' => 'id', 'label' => 'Flight ID', 'rules' => 'alpha_numeric|exact_length[5]'],
                ['field' => 'depart', 'label' => 'Departure Airport', 'rules' => 'alpha|exact_length[3]'],
                ['field' => 'depart_time', 'label' => 'Departure Time', 'rules' => 'required|my_func'],
                ['field' => 'arrive', 'label' => 'Arrival Airport', 'rules' => 'alpha|exact_length[3]'],
                ['field' => 'arrive_time', 'label' => 'Arrival Time', 'rules' => 'required|my_func'],
            );
        return $config;
    }
    
}
