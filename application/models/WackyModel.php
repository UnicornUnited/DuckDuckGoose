<?php
/**
 * This data model is used to retrieve live data from the wacky server.
 * https://wacky.jlparry.com/
 */
class WackyModel extends CI_Model
{
    private $my_airport_ids = array('YGE', 'ZMH', 'YYJ', 'YVE');
    private $my_base_airport_id = 'YGE';

    // Constructor
    public function __construct()
    {
        parent::__construct();

    }
    
    private function getAPI($api){
        return file_get_contents('https://wacky.jlparry.com/'.$api);
    }
    
    /**
     * return an array of airlines data. Retrieve all by default unless a given
     * airline name is given.
     * @param type $name a given airline name to retrieve
     * @return array
     */
    public function airlines($name=''){
        $response = $this->getAPI('info/airlines/'.$name);
        $data = [];
        if(!empty($response)){
            $data = json_decode($response, true);
            if($data === NULL)
                return [];
        }
        return $data;
    }
    
    /**
     * return an array of airports data. Retrieve all by default unless a given
     * airport name is given.
     * @param type $name a given airport name to retrieve
     * @return array
     */
    public function airports($name=''){
        $response = $this->getAPI('info/airports/'.$name);
        $data = [];
        if(!empty($response)){
            $data = json_decode($response, true);
            if($data === NULL)
                return [];
        }
        return $data;
    }
    
    /**
     * An alias of airports($id)
     * @param type $id
     * @return type
     */
    public function getAirport($id){
        return $this->airports($id);
    }
    
    public function listMyAirports(){
        $all = $this->airports();
        $my = array();
        foreach ($all as $key => $airport) {
            if(in_array($airport['id'], $this->my_airport_ids)){
                $my[] = $airport;
            }
        }
        return $my;
    }
    
    /**
     * return an array of airplanes data. Retrieve all by default unless a given
     * airplane name is given.
     * @param type $name a given airplane name to retrieve
     * @return array
     */
    public function airplanes($name=''){
        $response = $this->getAPI('info/airplanes/'.$name);
        $data = [];
        if(!empty($response)){
            $data = json_decode($response, true);
            if($data === NULL)
                return [];
        }
        return $data;
    }
    
    /**
     * An alias of airplanes($id)
     * @param type $id
     * @return type
     */
    public function getPlane($id){
        return $this->airplanes($id);
    }
    
    /**
     * return an array of regions data. Retrieve all by default unless a given
     * region name is given.
     * @param type $name a given region name to retrieve
     * @return array
     */
    public function regions($name=''){
        $response = $this->getAPI('info/regions/'.$name);
        $data = [];
        if(!empty($response)){
            $data = json_decode($response, true);
            if($data === NULL)
                return [];
        }
        return $data;
    }
    
    /**
     * An alias of regions() that returns all regions.
     */
    public function listRegion(){
        return $this->regions();
    }

}
