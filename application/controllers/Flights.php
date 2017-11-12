<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Flights extends Application
{
    
    /**
     * Constructor for the Flights Controller.
     */
    function __construct() {
        parent::__construct();
    }
        
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/
     * 	- or -
     * 		http://example.com/welcome/index
     *
     * So any other public methods not prefixed with an underscore will
     * map to /welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        //What role am I calling?
        $role = $this->session->userdata('userrole');

        if ($role == ROLE_GUEST){
            $this->load->model('flightModel');
            $this->data['pagebody'] = 'flights';
            $source = $this->flightModel->all();
            $this->data['flightdata'] = $source;
            $this->render();
        }

        if ($role == ROLE_ADMIN){
            $this->load->model('flightModel');
            $this->data['pagebody'] = 'adminflights';
            $source = $this->flightModel->all();
            $this->data['flightdata'] = $source;
            $this->render();
        }
    }

    //MY UPDATE FUNCTION DIDN'T WANT TO WORK. If disabled it for further debugging :(
//    public function update($id = null, $departAirport = null, $depart_time = null, $arrival = null, $arrival_time = null)
//    {
//        //If any of the fields are left empty don't do anything and return to flights page
//        if ($id == null or $departAirport = null or $depart_time = null or $arrival = null or $arrival_time = null )
//            redirect('/flights');
//
//
//        $newdata = array ($id => ((Object) array('id' => $id, 'depart_airport' => $departAirport, 'depart_time' => $depart_time, 'arrival' => $arrival, 'arrival_time' => $arrival_time)));
//        $this->load->model('flightModel');
//        //Updates records that match key
//        $flightmodel = $this->flightModel->update($newdata);
////        $this->session->set_userdata('flightModel', (object)$flightmodel);
//        $this->data['pagebody'] = 'adminflights';
//        $source = $this->flightModel->all();
//        $this->data['flightdata'] = $source;
//        $this->render();
//    }

}
