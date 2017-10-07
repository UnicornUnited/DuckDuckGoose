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
        $this->load->model('fleetModel');
        $data = null;
        if($id === "") {
            $data = $this->fleetModel->all(); 
            
        }
        else {
            $data = $this->fleetModel->get($id);
        }
        print_r(json_encode($data));
    }
    
    /**
     * Return info for flights.
     * @param type string $id specifies a flight id to load. leave it blank to 
     * retrieve all.
     */
    public function flights($id = ""){
        $this->load->model('flightModel');
        $data = null;
        if($id === "") {
            $data = $this->flightModel->all(); 
            
        }
        else {
            $data = $this->flightModel->get($id);
        }
        print_r(json_encode($data));
    }
}
?>

