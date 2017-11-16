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
        $this->data['pagebody'] = 'flightbooking';
        
        //Load the airports that our airline flies to and from
        $this->load->model('WackyModel');
        $airports = $this->wackymodel->listMyAirports();
        
        $this->data['airports'] = $airports;        
        $this->render();
    }
    
    /**
     * Displays the list of flights that match the departure and destination
     * airports specified.
     */
    public function availableFlights()
    {
        $this->data['pagebody'] = 'flightbooking_display';
          
        $depart = $this->input->post('departure');
        $dest = $this->input->post('destination');
        
        
        //Load the flights that match our criteria
        $this->load->model('flightmodel');
        $flights = $this->flightmodel->getFlightsByAirports($depart, $dest);
        
        
        $this->data['availableflights'] = $flights;
          
        $this->render();
    }
    
    /**
     * Validate and process the input from the form.
     */
//    public function searchFlights()
//    {
//        $depart = $this->input->post('departure');
//        $dest = $this->input->post('destination');
//        
//        $this->load->library('form_validation');
//        
//        $this->form_validation->set_rules('departure','Departure',
//                'required|callback__compare');
//                           
//        if ($this->form_validation->run() == FALSE)
//        {
//            redirect('booking');
//        }
//        else
//        {
//            redirect('booking/availableflights');
//        }  
//    }
    
    /**
     * Compares the departure and destination airports to see if they match.
     * @param string $dest
     * @param string $depart
     * @return boolean
     */
//    function _compare($depart, $dest)
//    {
//        if($depart == $dest){
//            $this->form_validation->set_message('_compare', 'Departure and '
//                    . 'Destination cannot be the same.');
//            return false;
//        }
//        return true;
//    }
}
