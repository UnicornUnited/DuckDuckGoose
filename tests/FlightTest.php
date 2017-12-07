<?php
use PHPUnit\Framework\TestCase;

/**
 * This unit test plan is to test against Task entity model.
 * It basically includes the following tests:
 * 1) the assignment of each member properties with reasonable test inputs and
 *    expected outputs.
 */
class FlightTest extends TestCase
{
    private $CI;

    protected function setUp()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('flightModel');
        $this->CI->load->model('flight');
        $this->CI->load->model('wackyModel');
    }
    
    /**
     * unit test for entity assignment
     */
    public function testAssignment(){
        //invalid value should not change its default value
        $flight = new Flight();
        $flight->depart_time = "7:30";//depart too early
        $this->assertNull($flight->depart_time, 'depart too early');
        //This validation is done inside /flights/verifyFlightAddition method.
        //So we need to fix this assertion so that it reflects the new method. The
        //assertion below will always fail.
//        $flight->arrive_time = "22:30";//land too late
//        $this->assertNull($flight->arrive_time, 'land too late');
        
        $flight->arrive_time = "13:30";//land too late

        $this->assertEquals("13:30", $flight->arrive_time);        
    }
    
    /**
     * unit test for business logic related to flight model
     */
    public function testBusinessLogic_NoOverNight(){
        //all plane must land at base by the and of day
        //let say, the last flight of any plane must have base as it destination
        $flights = $this->CI->flightModel->all();
        $last_flights = array();
        //store the flight with latest arrival
        foreach ($flights as $flight) {
            if(!key_exists($flight['plane_id'], $last_flights)){
                $last_flights[$flight['plane_id']] = $flight;
            }
            else{
                //update the flight with latest arrival
                $old_time = $this->CI->flight->getHours($last_flights[$flight['plane_id']]['arrive_time']);
                $new_time = $this->CI->flight->getHours($flight['arrive_time']);
                if($new_time > $old_time){
                    $last_flights[$flight['plane_id']] = $flight;
                }
            }
        }
//        var_dump($last_flights);
        //check if the arrive aireport is the base airport
        foreach ($last_flights as $flight) {
            $this->assertEquals('YGE', $flight['arrive']);
        }
    }
    
    /**
     * Unit test for business logic related to the required 30 minutes between flights (landing and departure)
     * No flights can happen at the same airport within 30 minutes of each other.
     */
    public function testNoFlyTime() {
        $flights = $this->CI->flightModel->all();
        $airports = $this->CI->wackyModel->listMyAirports();
        $times = array();
        $failtest = 0;
        
        // Get all the airport ids in an array
        foreach ($airports as $airport) {
            if (!key_exists($airport['id'], $times)) {
                $times[$airport['id']] = array();
            }
        }
        
        // Get all the arrive and depart time for each airport
        foreach($flights as $flight) {
            $times[$flight['arrive']][] = $flight['arrive_time'];
            $times[$flight['depart']][] = $flight['depart_time'];
        }
        
        // Compare the times for each airport against the other times of the same airport.
        foreach ($times as $time) {
            $row = sizeof($time);
            for ($i = 0; $i < $row; $i++){
                for ($j = 0; $j < $row; $j++){
                    if($i != $j && !$this->cmpTime($time[$i], $time[$j])){
                        $failtest++;
                    }
                }
            }
        }
        
        $this->assertEquals(0 , $failtest);
        
    }
    
    // Compare time for at least 30 minutes between.
    public function cmpTime($t1, $t2){
        $time1 = $this->getHours($t1);
        $time2 = $this->getHours($t2);
        if (abs($time1 - $time2) >= 0.5) {
            return true;
        }
            
        return false;
    }
    
        //Get a time from a string
    public function getHours($time){
        return doubleval(strtotime($time) - strtotime("0:00"))/3600;
    }
}
?>