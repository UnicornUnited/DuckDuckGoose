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
        return 'G' . (1000 + 10 * ($this->size() + 1));
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
     * Collects all departure/arrival times for the specified airport
     * id. Can be used to ensure a selected flight won't arrive at the
     * same time as another scheduled flight.
     * @param $airport_id
     */
    public function getAllArrivalDepartureTimes($airport_id){
        $records = parent::all();
        $resource = array();
        foreach($records as $key => $record){
            if($record->depart == $airport_id){
                //print_r($record->depart_time);
                array_push($resource, $record->depart_time);
            }
            if($record->arrive == $airport_id){
                //print_r($record->arrive_time);
                array_push($resource, $record->arrive_time);
            }

        }
        //print_r($resource);
        return $resource;
    }
    
    /**
     * Get the flights that depart from and arrive to airports specified by
     * the user.
     * @param type $dep departure airport
     * @param type $des arrival airport
     */
    public function getFlightsByDepart($departure){
        $all = $this->all();
        $flights = array();
        foreach ($all as $flight) {
            if($flight['depart'] == $departure){
                $flights[$flight['id']] = $flight;
            }
        }
        return $flights;
    }
    
    /**
     * Get the flights that a plane is assigned to
     * the user.
     * @param type $plane_id plane id
     */
    public function getFlightsByPlane($plane_id){
        $all = $this->all();
        $flights = array();
        foreach ($all as $flight) {
            if($flight['plane_id'] == $plane_id){
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
            );
        return $config;
    }
    
    /**
     * Retrieves flights from a particular airport that match the criteria 
     * that the user passes in to book flights.
     * @param array $potential
     * @param string $dest
     * @return array
     */
    public function retrieveFlights($potential, $dest){
        $temp = array();
        $result = array();
        foreach ($potential as $flight) {
            $size = count($flight);
            $retrieved = $this->getFlightsByDepart($flight[$size - 1]['arrive']);
            foreach ($retrieved as $trip) {
                if ($trip['arrive'] == $dest && $this->checkTime($flight[$size - 1], $trip)) {
                    $flight[$size] = $trip;
                    $result[] = $flight;
                } else if ($this->checkTime($flight[$size - 1], $trip)) 
                {
                    $flight[$size] = $trip;
                    $temp[] = $flight;               
                }
            }            
        }
        
        return array('potential' => $temp, 'flights' => $result);
    }
    
    /**
     * Validate the business logic: 
     * 1. A stopover flight must not depart before the initial flight
     * 2. There must be 30 mins between stopover flights
     * @param flight $f1
     * @param flight $f2
     * @return boolean
     */
    public function checkTime($f1, $f2) {
        if ($this->getHours($f2['depart_time']) < $this->getHours($f1['arrive_time'])) {
            return false;
        }
        
        if (($this->getHours($f2['depart_time']) - $this->getHours($f1['arrive_time'])) < .5) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Convert and return a decimal representing the given time in how many
     * hours passed since 0:00 am.
     * giving 8:30 will return 8.5, while giving 13:00 returns 13.0 etc.
     * @param type $time a time format to convert.
     * @return type double
     */
    public function getHours($time){
        return doubleval(strtotime($time) - strtotime("0:00"))/3600;
    }
}
