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

    // Initiate adding a new flight
    public function add()
    {
        $this->load->model('flightModel');
        $flightModel = $this->flightModel->create();
        $this->session->set_userdata('flightModel', $flightModel);
        $this->showit();
    }

    // Render the current DTO
    private function showit()
    {
        $this->load->helper('form');
        $task = $this->session->userdata('flightModel');
//        var_dump($task);
//        $this->data['id'] = $task->id;
//
//        // if no errors, pass an empty message
//        if ( ! isset($this->data['error']))
//            $this->data['error'] = '';

//        {fid}
//        {fplaneid}
//        {fdepart}
//        {fdepart_airport}
//        {fdepart_time}
//        {farrival}
//        {farrival_airport}
//        {farrival_time}
//        {zsubmit}

        //THE BELOW SHOULD IDEALLY BE CALLED FROM APP MODEL.
        //I DIDN'T MANAGE TO MAKE APP MODEL WORK :(
        // Planes
        $planeid = [
        1 => 'Grand Caravan Ex',
        2 => 'PC-12 NG',
        3 => 'Phenom 100'
        ];

        // Airport Codes
        $airportcodes = [
        1	 => 'YVE',
        2	 => 'YGE',
        3	 => 'ZMH',
        4	 => 'YYJ',
        5    => 'ZMH'
        ];

        // if no errors, pass an empty message
        if ( ! isset($this->data['error']))
            $this->data['error'] = '';

        $fields = array(
            'fid'      => form_label('Flight ID') . form_input('id', $task->id),
            'fplaneid'  => form_label('Plane ID') . form_dropdown('plane', $planeid, $task->plane),
            'fdepart'      => form_label('Departure Location') . form_dropdown('depart', $airportcodes, $task->depart),
            'fdepart_airport'      => form_label('Departure Airport') .form_input('depart_airport', $task->depart_airport),
            'fdepart_time'      => form_label('Departure Time') . form_input('depart_time', $task->depart_time),
            'farrival'      => form_label('Arrival Location') . form_dropdown('arrival', $airportcodes, $task->arrival),
            'farrival_airport'      => form_label('Arrival Airport') . form_input('arrival_airport', $task->arrival_airport),
            'farrival_time'      => form_label('Arrival Time') . form_input('arrival_time', $task->arrival_time),
            'zsubmit'    => form_submit('submit', 'Create Flight Details'),
        );
        $this->data = array_merge($this->data, $fields);

        $this->data['pagebody'] = 'itemedit';
        $this->render();
    }

}
