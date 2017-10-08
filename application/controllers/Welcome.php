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
        $this->data['pagebody'] = 'home';
        
        $this->load->model('flightModel');
        $flights = $this->flightModel->all();
        $numFlights = count($flights);
        
        $this->load->model('fleetModel');
        $planes = $this->fleetModel->all();
        $numPlanes = count($planes);
        
        $source = array(1 => array('flights' => $numFlights, 'planes' => $numPlanes));
        
        $this->data['airlineData'] = $source;
        $this->render(); 
    }

}
