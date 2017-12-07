<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Flights extends Application
{
    protected $golden_planes = array(
        '1','2','3'
    );
    protected $vernon_planes = array();
    protected $victoria_planes = array();
    protected $cariboo_planes = array();
    /**
     * Constructor for the Flights Controller.
     */
    function __construct() {
        parent::__construct();
        $this->load->model('flightModel');
        $this->load->model('flight');
        $this->load->model('wackyModel');
        $this->load->model('fleetModel');
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

        //TEST HERE

        //--END TEST

        if ($role == ROLE_ADMIN){
            
            $this->data['pagebody'] = 'adminflights';
            $source = $this->flightModel->all();
//            var_dump($source);
            $flights = $this->fleetModel->all();
            //list all planes
            $planes_raw = $this->wackyModel->airplanes();
            $planes = array();
            foreach ($planes_raw as $plane) {
                $planes[$plane['id']] = $plane;
            }
            //list all airports
            $airports_raw = $this->wackyModel->listMyAirports();
            //restructure the airport by key
            $airports = array();
            foreach ($airports_raw as $airport) {
                $airports[$airport['id']] = $airport;
            }
            
            //create dropdown options
            $plane_options = array();
            foreach ($flights as $flight) {
                $plane_options[$flight->id] = "(".$flight->id.") ".$planes[$flight->model_id]['model'];
            }
            
            $airport_options = array();
            foreach ($airports as $airport) {
                $airport_options[$airport['id']] = $airport['airport'];
            }
            
            //fill the source with additional data retrieving from wacky
            foreach ($source as $key => $flight) {
                //fill the airport name
                $source[$key]['depart_airport'] = $airports[$flight['depart']]['airport'];

                $source[$key]['arriv_airport'] = $airports[$flight['arrive']]['airport'];
                
                //create a form dropdown for plane for each flight
                $source[$key]['plane_selection'] = form_dropdown('plane_id', $plane_options, $flight['plane_id']);
                
                //create a form dropdown for departure for each flight
                $source[$key]['depart_selection'] = form_dropdown('depart', $airport_options, $flight['depart']);
                
                //create a form dropdown for arrival for each flight
                $source[$key]['arrive_selection'] = form_dropdown('arrive', $airport_options, $flight['arrive']);
            }
            
            $this->data['add_plane_selection'] = form_dropdown('plane_id', $plane_options, "");
            $this->data['add_depart_selection'] = form_dropdown('depart', $airport_options, "");
            $this->data['add_arrive_selection'] = form_dropdown('arrive', $airport_options, "");

            $this->data['flightdata'] = $source;
            $this->render();
        } else {
            //Will Render this page when user is explicitly (or not)
            // selected as guest
            
            $this->data['pagebody'] = 'flights';
            $source = $this->flightModel->all();
            $flights = $this->fleetModel->all();
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
                $source[$key]['plane'] = $planes[$flights[$flight['plane_id']]->model_id];
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
        $id = array("id" => null); //Will be autoassigned
        $arrive_time = array("arrive_time" => null); //Will be autoassigned

        $data = array_merge($id, $data); //This creates the array correctly
        $data = array_merge($arrive_time, $data); //This creates the array correctly
        $flight = new Flight($data); //This initializes the entity correctly

        // validate away
        if ($this->form_validation->run())
        {
            //Test flight details meet all validation requirements. If so, save flight
            //else show the list off all the criteria that a flight must meet.
            if ($this->verifyFlightAddition($flight)){ //Passes entity to verify flight
                $this->flightModel->saveFlight($flight);
                header( "refresh:3;url=/flights" );
                echo("A new flight was added successfully. You will be redirected to our flights page in a moment.");
            }
        } else
        {
            //error control if form validation fails
            header( "refresh:2;url=/flights" );
            echo("Some of the input you entered in our form was not correct. You will be redirected to our flights page in a moment.");
        }
    }

    /**
     * Verifies that the entity values meet all the validation requirements before the
     * data is updated in the CSV file.
     * @param $entity Flight Entity
     * @return bool True if the verification succeeds all criteria
     */
    public function verifyFlightAddition($entity){
        // FORMAT: Array ( [id] => [plane_id] => 1 [depart] => YGE [depart_time] => 08:00 [arrive] => YVE [arrive_time] => )
        $flightDetails = $entity->toArray(); //Collects all created flight details in array

        //Retrieve purchased planes with IDs
        $flights = $this->fleetModel->all();
        $planes = array();
        foreach ($flights as $key => $plane) {
            $planes[$plane->id] = $plane->model_id;
        }

        //Retrieve plane details from wacky in format:
        //Array ( [id] => kingair [manufacturer] => Beechcraft [model] => King Air C90 [price] => 3900 [seats] => 12 [reach] => 2446 [cruise] => 500 [takeoff] => 1402 [hourly] => 990 )
        $planeDetails = $this->wackyModel->getPlane($planes[$flightDetails['plane_id']]);

        //Retrieving distance between depart and arrive airport:
        $dist = $this->returnAirportDistance($flightDetails['depart'], $flightDetails['arrive']);

        //Total flight duration in minutes is distance/speed times 60 plus 10 minutes
        $flightDuration = (($dist/$planeDetails['cruise'])*60)+10;

        //VALIDATION
        //1)Selected plane must be able to arrive to destination
        if($planeDetails['reach'] < $dist){
            //plane cannot fly to location so new flight cannot be accepted
            echo("Plane cannot reach destination");
            return false;
        }
        //2)Ensure depart times are between 8am and 10pm. Note: arrive_time will be auto set up
        if($entity->getHours($flightDetails['depart_time']) < 8 ){
            echo("Cannot depart at ".$flightDetails['depart_time']);
            return false;
        }

        //3)Check that there are no planes departing or arriving on the
        //selected airport at the selected timestamp (This is a compromise to a more complex logic)
        foreach ($this->flightModel->getAllArrivalDepartureTimes($flightDetails['depart']) as $time){
            if ($time == $flightDetails['depart_time']){
                echo("Other planes departing at ".$flightDetails['depart_time']." from ".$flightDetails['depart']);
                return false;
            }
        }

        //4)Calculate Arrival Time
        $arr_time = ($entity->getHours($flightDetails['depart_time'])) +  $flightDuration/60;

        //5) Check arrival time is not greater than 22:00 hours
        if ($arr_time > 22){
            echo("Cannot depart from ".$flightDetails['depart']." at ".$flightDetails['depart_time']." because the plane will arrive past 22:00 pm");
            return false;
        }

        //6)Set temporary arrival Time in string format and ensure it doesn't collide with any of the
        //arrival times in the airport.
        $timestamp = ($arr_time * 3600) +  strtotime("00:00");
        $arr_time_string = date('H:i',$timestamp);
        $timeslot_available = true;
        $coliding_arrival_time = "";
        foreach ($this->flightModel->getAllArrivalDepartureTimes($flightDetails['arrive']) as $time){
            if ($time == $arr_time_string){
                $timeslot_available = false;
                $coliding_arrival_time = $time;
                break;
            }
        }

        //If nothing returns false then set time to arrival time in string format $arr_time_string
        if($timeslot_available){
            $entity->setArriveTime($arr_time_string);
        } else {
            echo("There is another flight in ". $flightDetails['arrive']." arriving at the same time: ".$coliding_arrival_time.'\n');
            echo("Update that flight first");
            return false;
        }

        return true;
    }



    /**
     * Method used to pull the calculated distances between all the possible iterations
     * from one airport to another.
     * @param $depart Departure Airport Code
     * @param $arrive Arrival Airport Code
     * @return mixed returns a number representing distance between two airports
     */
    public function returnAirportDistance($depart, $arrive){
        $airportDistances = array(
            'YGE' => array('ZMH' => 306, 'YYJ' => 549, 'YVE' => 203),
            'ZMH' => array('YYJ' => 375, 'YVE' => 217, 'YGE' => 306),
            'YYJ' => array('YVE' => 346, 'YGE' => 549, 'ZMH' => 375),
            'YVE' => array('YGE' => 203, 'ZMH' => 217, 'YYJ' => 346)
        );

        return $airportDistances[$depart][$arrive];
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
