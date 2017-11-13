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
        $add = array("id" => null);
        // validate away
        if ($this->form_validation->run())
        {
//            unset($data['id']);
            //Needed to set this array merge cause PHP was complaining about not having an id
            $data = array_merge($add, $data);
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

//    // Initiate adding a new flight
//    public function add()
//    {
//        $this->load->model('flightModel');
//        $flightModel = $this->flightModel->create();
//        $this->session->set_userdata('flightModel', $flightModel);
//        $this->showit();
//    }

    // submit
    public function submit()
    {
        // FORM VALIDATION HAS NOT BEEN IMPLEMENTED
        // ...

        // retrieve & update data transfer buffer
        $this->load->model('flightModel');
        $task = (array)$this->session->userdata('flightModel');
        $task = array_merge($task, $this->input->post());
        $task = (object)$task;  // convert back to object
        //var_dump($task);

        $this->flightModel->add($task);
        redirect('/flights');

    }

//    // Render the current DTO
//    private function showit()
//    {
//        $this->load->helper('form');
//        $task = $this->session->userdata('flightModel');
////        var_dump($task);
////        $this->data['id'] = $task->id;
////
////        // if no errors, pass an empty message
////        if ( ! isset($this->data['error']))
////            $this->data['error'] = '';
//
////        {fid}
////        {fplaneid}
////        {fdepart}
////        {fdepart_airport}
////        {fdepart_time}
////        {farrival}
////        {farrival_airport}
////        {farrival_time}
////        {zsubmit}
//
//        //THE BELOW SHOULD IDEALLY BE CALLED FROM APP MODEL.
//        //I DIDN'T MANAGE TO MAKE APP MODEL WORK :(
//        // Planes
//        $planeid = [
//        1 => 'Grand Caravan Ex',
//        2 => 'PC-12 NG',
//        3 => 'Phenom 100'
//        ];
//
//        // Airport Codes
//        $airportcodes = [
//        1	 => 'YVE',
//        2	 => 'YGE',
//        3	 => 'ZMH',
//        4	 => 'YYJ',
//        5    => 'ZMH'
//        ];
//
//        // if no errors, pass an empty message
//        if ( ! isset($this->data['error']))
//            $this->data['error'] = '';
//
//        $fields = array(
//            'fid'      => form_label('Flight ID') . form_input('id', $task->id),
//            'fplaneid'  => form_label('Plane ID') . form_dropdown('plane', $planeid, $task->plane),
//            'fdepart'      => form_label('Departure Location') . form_dropdown('depart', $airportcodes, $task->depart),
//            'fdepart_airport'      => form_label('Departure Airport') .form_input('depart_airport', $task->depart_airport),
//            'fdepart_time'      => form_label('Departure Time') . form_input('depart_time', $task->depart_time),
//            'farrival'      => form_label('Arrival Location') . form_dropdown('arrival', $airportcodes, $task->arrival),
//            'farrival_airport'      => form_label('Arrival Airport') . form_input('arrival_airport', $task->arrival_airport),
//            'farrival_time'      => form_label('Arrival Time') . form_input('arrival_time', $task->arrival_time),
//            'zsubmit'    => form_submit('submit', 'Create Flight Details'),
//        );
//        $this->data = array_merge($this->data, $fields);
//
//        $this->data['pagebody'] = 'itemedit';
//        $this->render();
//    }

}
