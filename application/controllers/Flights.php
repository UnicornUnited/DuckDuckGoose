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

        if ($role == ROLE_ADMIN){
            $this->load->model('flightModel');
            $this->data['pagebody'] = 'adminflights';
            $source = $this->flightModel->all();
            $this->data['flightdata'] = $source;
            $this->render();
        } else {
            //Will Render this page when user is explicitly (or not)
            // selected as guest
            $this->load->model('flightModel');
            $this->data['pagebody'] = 'flights';
            $source = $this->flightModel->all();
            $this->data['flightdata'] = $source;
            $this->render();
        }


    }

    //MY UPDATE FUNCTION WORKS NOW!.
    // id,plane,depart,depart_airport,depart_time,arrival,arrival_airport,arrival_time
    public function update()
    {
        //Catching all the variables from the URL (sent from adminflights)
        $id = $_POST['id'];
        $departAirport = $_POST['depart_airport'];
        $depart_time = $_POST['depart_time'];
        $arrival = $_POST['arrival'];
        $arrival_time = $_POST['arrival_time'];

        //Test URL values are grabbed (YES)
//        echo ($id);
//        echo ($departAirport);
//        echo ($depart_time);
//        echo ($arrival);
//        echo ($arrival_time);

        //If any of the fields are left empty don't do anything and return to flights page
        //I'LL NEED TO IMPLEMENT THIS EVENTUALLY.
//        if ($id == '' or $departAirport = '' or $depart_time = '' or $arrival = '' or $arrival_time = '' )
//            redirect('/flights');

        $this->load->model('flightModel');
        //Grabs the item for the specified ID
        $item = $this->flightModel->get($id);
        //In order to use the data, var needs to be casted as an array
        $converted = (array)$item;

        //Now $converted can be accessed using $var['name'] format
        //var_dump($converted['id']);
        //$converted['id'] = 'GXS';
        //var_dump($converted['id']);
        //echo($_GET('depart_airport'));

        //Accessing values that can be modified and modifying them accordingly
        $converted['depart_airport'] = $departAirport;
        $converted['depart_time'] = $depart_time;
        $converted['arrival'] = $arrival;
        $converted['arrival_time'] = $arrival_time;

        //Now we need to convert the array into an object as before
        $converted = (object)$converted;

        //The following test shows variables are changed accordingly
        //var_dump($converted);

        //Now we can pass the object to update CSV and re-render to see changes:
        $this->flightModel->update($converted);
        $this->index();
    }

}
