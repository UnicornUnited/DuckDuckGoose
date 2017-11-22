<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fleet extends Application
{
    /**
     * Ctor
     */
    public function __construct() {
        parent::__construct();
        // Load the FleetModel
        $this->load->model('fleetModel');
        // Load the Plane Entity Model
        $this->load->model('plane');
        // Load the Wachy Data Model
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
        $role = $this->session->userdata('userrole');
        // Load the FlightModel
        $this->load->model('flightModel');
        // Load the Flight Entity Model
        $this->load->model('flight');
        // Select the desired view for the list of planes
        
        if ($role == ROLE_ADMIN) 
        {
            $this->data['pagebody'] = 'fleetedit';
        } else
        {
            $this->data['pagebody'] = 'fleet';
        }
        // Retrieve the fleet data
        $source = $this->fleetModel->all();

        $temp = $this->wackyModel->airplanes();
        $planes = array();
        foreach($temp as $key=>$plane){
            $planes[$plane['id']] = $plane;
        }
        
        $flights = $this->flightModel->all();
//        var_dump($flights);
        $airport_count = array();
        $flight_count = array();
        $earliest_flights = array();
        $latest_flights = array();
        
        foreach($flights as $key=>$flight){
            //airport count
            if(!key_exists($flight['plane_id'], $airport_count)){
                $airport_count[$flight['plane_id']] = array();
            }
            $airport_count[$flight['plane_id']][$flight['depart']] = 1;
            $airport_count[$flight['plane_id']][$flight['arrive']] = 1;
            //flight count
            if(!key_exists($flight['plane_id'], $flight_count)){
                $flight_count[$flight['plane_id']] = 0;
            }
            $flight_count[$flight['plane_id']] ++;
            //earliest flight
            if(!key_exists($flight['plane_id'], $earliest_flights)){
                $earliest_flights[$flight['plane_id']] = 
                        array(
                            'id'=>$flight['id'],
                            'hours'=>$this->flight->getHours($flight['depart_time']), 
                            'depart_time'=>$flight['depart_time'], 
                            'depart'=>$flight['depart'],
                            'arrive_time'=>$flight['arrive_time'], 
                            'arrive'=>$flight['arrive']
                        );
            }
            else if($earliest_flights[$flight['plane_id']]['hours'] > $this->flight->getHours($flight['depart_time'])){
                $earliest_flights[$flight['plane_id']] = 
                        array(
                            'id'=>$flight['id'],
                            'hours'=>$this->flight->getHours($flight['depart_time']), 
                            'depart_time'=>$flight['depart_time'], 
                            'depart'=>$flight['depart'],
                            'arrive_time'=>$flight['arrive_time'], 
                            'arrive'=>$flight['arrive']
                        );
            }
            //latest flight
            if(!key_exists($flight['plane_id'], $latest_flights)){
                $latest_flights[$flight['plane_id']] = 
                        array(
                            'id'=>$flight['id'],
                            'hours'=>$this->flight->getHours($flight['depart_time']), 
                            'depart_time'=>$flight['depart_time'], 
                            'depart'=>$flight['depart'],
                            'arrive_time'=>$flight['arrive_time'], 
                            'arrive'=>$flight['arrive']
                        );
            }
            else if($latest_flights[$flight['plane_id']]['hours'] < $this->flight->getHours($flight['depart_time'])){
                $latest_flights[$flight['plane_id']] = 
                        array(
                            'id'=>$flight['id'],
                            'hours'=>$this->flight->getHours($flight['depart_time']), 
                            'depart_time'=>$flight['depart_time'], 
                            'depart'=>$flight['depart'],
                            'arrive_time'=>$flight['arrive_time'], 
                            'arrive'=>$flight['arrive']
                        );
            }
        }
        
        foreach($source as $key=>$plane){
            $source[$key]->plane_name = $planes[$plane->model_id]['model'];
            //airport_count
            $source[$key]->airport_count = 0;
            if(key_exists($plane->id, $airport_count)){
                $source[$key]->airport_count = count($airport_count[$plane->id]);
            }
            //flight_count
            $source[$key]->flight_count = 0;
            if(key_exists($plane->id, $flight_count)){
                $source[$key]->flight_count = $flight_count[$plane->id];
            }
            //earliest flight
            if(key_exists($plane->id, $earliest_flights)){
//                $source[$key]->earliest_flight_link = '/flight/'.$earliest_flights[$plane->id]['id'];
                $source[$key]->earliest_depart = $earliest_flights[$plane->id]['depart_time'];
                $source[$key]->earliest_source = $earliest_flights[$plane->id]['depart'];
                $source[$key]->earliest_arrive = $earliest_flights[$plane->id]['arrive_time'];
                $source[$key]->earliest_destination = $earliest_flights[$plane->id]['arrive'];
            }
            else{
//                $source[$key]->earliest_flight_link = '#this';
                $source[$key]->earliest_depart = '--:--';
                $source[$key]->earliest_source = 'N/A';
                $source[$key]->earliest_arrive = '--:--';
                $source[$key]->earliest_destination = 'N/A';
            }
            //latest flight
            if(key_exists($plane->id, $latest_flights)){
                $source[$key]->latest_depart = $latest_flights[$plane->id]['depart_time'];
                $source[$key]->latest_source = $latest_flights[$plane->id]['depart'];
                $source[$key]->latest_arrive = $latest_flights[$plane->id]['arrive_time'];
                $source[$key]->latest_destination = $latest_flights[$plane->id]['arrive'];
            }
            else{
                $source[$key]->latest_depart = '--:--';
                $source[$key]->latest_source = 'N/A';
                $source[$key]->latest_arrive = '--:--';
                $source[$key]->latest_destination = 'N/A';
            }
        }
//        var_dump($source);
        $this->data['plane_items'] = $source;
        $this->render();
     
    }

    public function plane($key)
    {
        // Select the desired view for the plane details
        $this->data['pagebody'] = 'plane';
        // Retrieve just the desired plane
        $source = (array)$this->fleetModel->get($key);
        
        $detail = $this->wackyModel->getPlane($source['model_id']);
        
        $source['type'] = $detail['model'];
        $source['speed'] = $detail['cruise'] . ' kph';
        
        $this->data = array_merge($this->data, (array) $source);
        $this->render();
    }
    
    //Initiate adding a new plane
    public function add()
    {
        $this->load->model('plane');
        $plane = new Plane();
        $this->session->set_userdata('plane', $plane);
        $this->showit();
    }
    
    //Initiate editing of a plane
    public function edit($id = null)
    {
        // Load the FleetModel
        $this->load->model('fleetModel');
        $this->load->model('plane');
        if ($id == null)
            redirect ('/fleet');
        //$plane = $this->fleetModel->get($id);
        $rec = (array)$this->fleetModel->get($id);
        $plane = new Plane($rec);
 
        $this->session->set_userdata('plane', $plane);
        $this->showit();
    }
    
    //Render the current DTO
    private function showit()
    {
        $this->load->model('plane');
        $this->load->helper('form');
        $plane = $this->session->userdata('plane');
        $this->data['id'] = $plane->id;
       
        // if no errors, pass an empty message
        if (!isset($this->data['error'])) {
            $this->data['error'] = '';
        }

        // Still need to edit this
        $fields = array(
            'fid'       => form_label('Model Id') . form_dropdown( 'model_id', $this->model_id(), $plane->model_id),
            'zsubmit'   => form_submit('submit', 'Update Plane'),
        );
        $this->data = array_merge($this->data, $fields);

        $this->data['pagebody'] = 'planeedit';
        $this->render();
    }
    
    // Handle Form Submission
    public function submit()
    {
        $this->load->model('fleetModel');
        $this->load->model('plane');
        
        // Setup for validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->fleetModel->rules());
        
        // Retrieve & update data transfer buffer
        $plane = unserialize( (serialize($this->session->userdata('plane'))));
        $input = $this->input->post();
        $plane->model_id = $input['model_id'];
        $this->session->set_userdata('plane', $plane);
        
        // Validate plane
        if ($this->form_validation->run())
        {   
            if(empty($plane->id)){
                
                $plane->id = $this->fleetModel->saveFleet($plane);
                $this->alert('New Plane Added', 'success');
            } else 
            {
                $this->fleetModel->saveFleet($plane);
                $this->alert('Plane ' . $plane->id . ' Updated', 'success');
            }
        } else
        {
            $this->alert('<strong>Validation errors!<strong><br>' . validation_errors(), 'danger');
        }
        $this->showit();
    }
    
    public function cancel()
    {
        $this->session->unset_userdata('plane');
        redirect('/fleet');
    }
    
    public function delete()
    {
        // Load Models
        $this->load->model('fleetModel');
        $this->load->model('plane');
        
        // Yes, it is very hacky.
        $plane = unserialize((serialize($this->session->userdata('plane'))));
        
        $this->fleetModel->deleteFleet($plane);
        $this->session->unset_userdata('plane');
        
        redirect('/fleet');
    }
    
    // build a suitable error mesage
    private function alert($message) {
        $this->load->helper('html');        
        $this->data['error'] = heading($message,3);
    }
    
    // Retrieves all the Plane Models
    private function model_id()
    {
        $this->load->model('wackyModel');
        $planes = $this->wackyModel->airplanes();
        $model_id = array();
        
        
        
        foreach ($planes as $plane)
        {
            
            $model_id[$plane['id']] = $plane['id'];
        }
        
        return $model_id;
    }
}
