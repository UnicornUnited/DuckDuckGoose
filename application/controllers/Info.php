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
     * This service controller does not provide anything by default. Redirect to
     * home.
     */
    public function index(){
        redirect('/');
    }
    
    /**
     * Return info for fleet.
     * @param type string $id specifies a plane id to load. leave it blank to 
     * retrieve all.
     */
    public function fleet($id = ""){
        $this->load->model('fleetModel');
        $data = NULL;
        if($id === "") {
            $data = $this->fleetModel->all(); 
            
        }
        else {
            $data = $this->fleetModel->get($id);
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
    
    /**
     * Return info for flights.
     * @param type string $id specifies a flight id to load. leave it blank to 
     * retrieve all.
     */
    public function flights($id = ""){
        $this->load->model('flightModel');
        $data = NULL;
        if($id === "") {
            $data = $this->flightModel->all(); 
            
        }
        else {
            $data = $this->flightModel->get($id);
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
}
?>