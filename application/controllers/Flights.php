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
        $this->load->model('flightModel');
        $this->data['pagebody'] = 'flights';
        $source = $this->flightModel->all();
        $this->data['flightdata'] = $source;
        $this->render(); 
    }

}
