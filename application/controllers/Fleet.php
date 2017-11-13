<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fleet extends Application
{
    /**
     * Ctor
     */
    public function __construct() {
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
        // Load the FleetModel
        $this->load->model('fleetModel');
        // Select the desired view for the list of planes
        $this->data['pagebody'] = 'fleet';
        // Retrieve the fleet data
        $source = $this->fleetModel->all();
        $this->data['plane_items'] = $source;
        $this->render();
     
    }

    public function plane($key)
    {
        // Load the FleetModel
        $this->load->model('fleetModel');
        // Select the desired view for the plane details
        $this->data['pagebody'] = 'plane';
        // Retrieve just the desired plane
        $source = (array)$this->fleetModel->get($key);
        $this->data = array_merge($this->data, (array) $source);
        $this->render();
    }
    
    public function delete(){
        echo((strtotime("13:30") - strtotime("0:00"))/3600);
    }
}
