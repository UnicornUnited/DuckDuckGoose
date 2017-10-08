<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Application
{

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
        //Get content from home view
        $this->data['pagebody'] = 'home';
        
        //count and store the number of flights
        $this->load->model('flightModel');
        $flights = $this->flightModel->all();
        $numFlights = count($flights);
        
        //count and store the number of planes in the fleet
        $this->load->model('fleetModel');
        $planes = $this->fleetModel->all();
        $numPlanes = count($planes);
        
        //send the data to the view
        $source = array(1 => array('flights' => $numFlights, 'planes' => $numPlanes));
        $this->data['airlineData'] = $source;
        
        $this->render(); 
    }

}
