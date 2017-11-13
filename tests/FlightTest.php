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
    }
    
    /**
     * unit test for entity assignment
     */
    public function testAssignment(){
        //invalid value should not change its default value
        $flight = new Flight();
        $flight->depart_time = "7:30";//depart too early
        $this->assertNull($flight->depart_time, 'depart too early');
        
        $flight->arrive_time = "22:30";//land too late
        $this->assertNull($flight->arrive_time, 'land too late');
        
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
            if(!key_exists($flight['model_id'], $last_flights)){
                $last_flights[$flight['model_id']] = $flight;
            }
            else{
                //update the flight with latest arrival
                $old_time = $this->CI->flight->getHours($last_flights[$flight['model_id']]['arrive_time']);
                $new_time = $this->CI->flight->getHours($flight['arrive_time']);
                if($new_time > $old_time){
                    $last_flights[$flight['model_id']] = $flight;
                }
            }
        }
//        var_dump($last_flights);
        //check if the arrive aireport is the base airport
        foreach ($last_flights as $flight) {
            $this->assertEquals('YGE', $flight['arrive']);
        }
    }
}
?>