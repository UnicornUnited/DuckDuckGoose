<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Flights extends Application
{
    
    /**
     * Constructor for the Flights Controller.
     */
    function __construct() {
        parent::__construct();
        $this->load->model('flightModel');
        $this->load->model('flight');
        $this->load->model('wackyModel');
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
        $this->load->helper('form');
        //What role am I calling?
        $role = $this->session->userdata('userrole');

        if ($role == ROLE_ADMIN){
            
            $this->data['pagebody'] = 'adminflights';
            $source = $this->flightModel->all();
            //list all planes
            $planes = $this->wackyModel->airplanes();
            //list all airports
            $airports_raw = $this->wackyModel->listMyAirports();
            //restructure the airport by key
            $airports = array();
            foreach ($airports_raw as $airport) {
                $airports[$airport['id']] = $airport;
            }
            
            //create dropdown options
            $plane_options = array();
            foreach ($planes as $plane) {
                $plane_options[$plane['id']] = $plane['model'];
            }
            
            $airport_options = array();
            foreach ($airports as $airport) {
                $airport_options[$airport['id']] = $airport['airport'];
            }
            
//            var_dump($source);
            //fill the source with additional data retrieving from wacky
            foreach ($source as $key => $flight) {
                //fill the airport name
                $source[$key]['depart_airport'] = $airports[$flight['depart']]['airport'];

                $source[$key]['arriv_airport'] = $airports[$flight['arrive']]['airport'];
                
                //create a form dropdown for plane for each flight
                $source[$key]['plane_selection'] = form_dropdown('model_id', $plane_options, $flight['model_id']);
                
                //create a form dropdown for departure for each flight
                $source[$key]['depart_selection'] = form_dropdown('depart', $airport_options, $flight['depart']);
                
                //create a form dropdown for arrival for each flight
                $source[$key]['arrive_selection'] = form_dropdown('arrive', $airport_options, $flight['arrive']);
            }
            
            $this->data['add_plane_selection'] = form_dropdown('model_id', $plane_options, "");
            $this->data['add_depart_selection'] = form_dropdown('depart', $airport_options, "");
            $this->data['add_arrive_selection'] = form_dropdown('arrive', $airport_options, "");

            $this->data['flightdata'] = $source;
            $this->render();
        } else {
            //Will Render this page when user is explicitly (or not)
            // selected as guest
            
            $this->data['pagebody'] = 'flights';
            $source = $this->flightModel->all();
            //list all planes
            $planes_raw = $this->wackyModel->airplanes();
            $planes = array();
            foreach ($planes_raw as $plane) {
                $planes[$plane['id']] = $plane['model'];
            }
            //list all airports
            $airports_raw = $this->wackyModel->listMyAirports();
            //restructure the airport by key
            $airports = array();
            foreach ($airports_raw as $airport) {
                $airports[$airport['id']] = $airport;
            }
            
            foreach ($source as $key => $flight) {
                $source[$key]['plane'] = $planes[$flight['model_id']];
            }
            
            $this->data['flightdata'] = $source;
            
            $this->render();
        }


    }

    public function add()
    {
        // setup for validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->flightModel->formRules());
        $data = $this->input->post();
        // validate away
        if ($this->form_validation->run())
        {
            unset($data['id']);
            $flight = new Flight($data);
            $flight_id = $this->flightModel->saveFlight($flight);

            redirect('/flights');
        } else
        {
            //error control
            redirect('/flights');
        }
    }
    
    public function update(){
        // setup for validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->flightModel->formRules());
        $data = $this->input->post();
        // validate away
        if ($this->form_validation->run())
        {
            $flight = new Flight($data);

            $flight_id = $this->flightModel->saveFlight($flight);

            redirect('/flights');
        } else
        {
            //error control
            redirect('/flights');
        }
    }

}
