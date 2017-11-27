<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends Application
{
    /**
     * Booking constructor.
     */
    function __construct() {
        parent::__construct();
    }
    
    /**
     * Displays the flight booking page where the user selects the 
     * destination and departure airports. 
     */
    public function index()
    {
        $this->data['pagebody'] = 'booking_flights';
        
        //Load the airports that our airline flies to and from
        $this->load->model('wackyModel');
        $airports = $this->wackyModel->listMyAirports();
        
        $this->data['airports'] = $airports;        
        $this->render();
    }
    
    /**
     * Displays the list of flights that match the departure and destination
     * airports specified.
     */
    public function availableFlights()
    {        
        $temp1 = array();
        $temp2 = array();
        $temp3 = array();
        $nonstops = array();
        $onestops = array();
        $twostops = array();
        
        $depart = $this->input->post('departure');
        $dest = $this->input->post('destination');    
        
        //Load the flights that match our criteria
        $this->load->model('flightModel');
        $flights = $this->flightModel->getFlightsByDepart($depart);
        
        //Get all flights that start at dept and end at arrive
        foreach ($flights as $flight) {
            if ($flight['arrive'] == $dest) {
                $nonstops[] = $flight;
            }
            else 
            {
                $temp1[][0]= $flight;
            }
        }
        
        //Get all flights that have 1 stopover
        foreach ($temp1 as $flight) {
            $temp2 = $this->flightModel->getFlightsByDepart($flight[0]['arrive']);
            foreach ($temp2 as $trip) {
                if ($trip['arrive'] == $dest && $this->checkTime($flight[0], $trip)) {
                    $flight[1] = $trip;
                    $onestops[] = $flight;
                }
                else if ($this->checkTime($flight[0], $trip)) 
                {
                    $flight[1] = $trip;
                    $temp3[] = $flight;
                                      
                }
            }
        }
        
        //Get all flights that have 2 stopover
        foreach ($temp3 as $flight) {
            $temp2 = $this->flightModel->getFlightsByDepart($flight[1]['arrive']);
            foreach ($temp2 as $trip) {
                if ($trip['arrive'] == $dest && $this->checkTime($flight[1], $trip)) {
                    $flight[2] = $trip;
                    $twostops[] = $flight;
                }
            }
        }
        
        $this->showBooking($nonstops,$onestops, $twostops);
    }
    
    /**
     * Format and display the available flights for specified departure and destination.
     * @param type $nonstops available flights with no stops
     * @param type $onestops available flights with one stop
     * @param type $twostops available flights with two stops
     */
    public function showBooking($nonstops, $onestops, $twostops){
        $flightrow = '';
        $options1 = array();
        $options2 = array();
        $options3 = array();
        $tables = array();
        $result = '';
        $count = 1;
        $count1 = 1;
        $count2 = 1;
        
        // Iterates through nonstops array if not empty
        if(!empty($nonstops)){
            $temp = '';
            
            // Each flight is added to options array
            foreach ($nonstops as $flight) {
                $flightrow = $this->parser->parse('booking_row', (array) $flight, true);
                $options1[] = array( 'option' => $count++ , 'flightrow' => $flightrow);
            }
            
            foreach ($options1 as $option) {
                $temp .= $this->parser->parse('booking_option', (array) $option, true);
            }
            
            $tables[] = array('stops' => 'Nonstop' , 'flightoptions' => $temp);
        }

        // Itereates through onestops array if not empty
        if(!empty($onestops)){
            $temp = '';
            $flow ='';
            
            // Each flight is added to options array
            foreach ($onestops as $flight) {
                $flightrow = $this->parser->parse('booking_row', (array) $flight[0], true);
                $flightrow .= $this->parser->parse('booking_row', (array) $flight[1], true);
                $flow = $flight[0]['depart'] . ' > ';
                $flow .= $flight[1]['depart'] . ' > ';
                $flow .= $flight[1]['arrive'];
                $options2[] = array( 'option' => $count1++ , 'flow' => $flow,'flightrow' => $flightrow);
            }
            
            foreach ($options2 as $option) {
                $temp .= $this->parser->parse('booking_option', (array) $option, true);
            }
            $tables[] = array('stops' => 'One Stop' , 'flightoptions' => $temp);
        }
  
        // Iterates through twostops array if not empty
        if(!empty($twostops)){
            $temp = '';
            $flow = '';
            
            // Each flight is added to options array
            foreach ($twostops as $flight) {
                $flightrow = $this->parser->parse('booking_row', (array) $flight[0], true);
                $flightrow .= $this->parser->parse('booking_row', (array) $flight[1], true);
                $flightrow .= $this->parser->parse('booking_row', (array) $flight[2], true);
                $flow = $flight[0]['depart'] . ' > ';
                $flow .= $flight[1]['depart'] . ' > ';
                $flow .= $flight[2]['depart'] . ' > ';
                $flow .= $flight[2]['arrive'];
                $options3[] = array( 'option' => $count2++ , 'flow' => $flow ,'flightrow' => $flightrow);
            }
            
            foreach ($options3 as $option) {
                $temp .= $this->parser->parse('booking_option', (array) $option, true);
            }
            
            $tables[] = array('stops' => 'Two Stops' , 'flightoptions' => $temp);
        }

        // Add tables contents if not empty
        if(!empty($tables)){
            foreach ($tables as $table) {
                $result .= $this->parser->parse('booking_header', (array) $table, true);
            }
        } else {
            $result = "Sorry, we do not had any available flights for the departure "
                    . "and destination you have chosen. We are trying to expand "
                    . "our reach. Please try again soon.";
        }
        
        $this->data['availableflights'] = $result;
        $this->data['pagebody'] = 'booking_display';
        $this->render();
    }
    
    //Validate the business logic: 
    //1. A stopover flight must not depart before the initial flight
    //2. There must be 30 mins between stopover flights
    public function checkTime($f1, $f2) {
        if ($this->getHours($f2['depart_time']) < $this->getHours($f1['arrive_time'])) {
            return false;
        }
        
        if (($this->getHours($f2['depart_time']) - $this->getHours($f1['arrive_time'])) < .5) {
            return false;
        }
        
        return true;
    }
    
    //Get a time from a string
    public function getHours($time){
        return doubleval(strtotime($time) - strtotime("0:00"))/3600;
    }
}