<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Info extends Application
{
    /**
     * The Ctor
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Return info for fleet.
     * @param type string $id specifies a plane id to load. leave it blank to 
     * retrieve all.
     */
    public function fleet($id = ""){
        $this->load->model('fleet');
        $data = null;
        if($id === "") {
            $data = $this->fleet->all(); 
            
        }
        else {
            $data = $this->fleet->get($id);
        }
        print_r(json_encode($data));
    }
    
    /**
     * Return info for flights.
     * @param type string $id specifies a flight id to load. leave it blank to 
     * retrieve all.
     */
    public function flights($id = ""){
        $this->load->model('flights');
        $data = null;
        if($id === "") {
            $data = $this->flights->all(); 
            
        }
        else {
            $data = $this->flights->get($id);
        }
        print_r(json_encode($data));
    }
}
?>

