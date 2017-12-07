<?php
use PHPUnit\Framework\TestCase;

/**
 * This unit test plan is to test against Task entity model.
 * It basically includes the following tests:
 * 1) the assignment of each member properties with reasonable test inputs and
 *    expected outputs.
 */
class BookingTest extends TestCase
{
    private $CI;

    protected function setUp()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('flightModel');
        $this->CI->load->model('flight');
    }
    
    /**
     * Test the ability to retrieve a flight with one stopover.
     */
    public function testYVEtoYGE() {
        $yve_yge_1 = array();
        $yve_yge_2 = array();
        
        $temp = $this->CI->flightModel->getFlightsByDepart('YVE');
        foreach ($temp as $flight) {
            $temp2[][] = $flight;
        }
        
        $result = $this->CI->flightModel->retrieveFlights($temp2, 'YGE');
        
        $yve_yge_1 = $result['flights'];
        $temp = $result['potential'];
        
        $result = $this->CI->flightModel->retrieveFlights($temp, 'YGE');
        
        $yge_yve_2 = $result['flights'];
        
        //One stopover
        $this->assertEquals('YVE', $yve_yge_1[0][0]['depart']); 
        $this->assertEquals('ZMH', $yve_yge_1[0][0]['arrive']);
        
        $this->assertEquals('ZMH', $yve_yge_1[0][1]['depart']);
        $this->assertEquals('YGE', $yve_yge_1[0][1]['arrive']);
        
        //Two stopovers
        $this->assertEmpty($yve_yge_2);
    }
    
 
    /**
     * Test the ability to retrieve a flight with one stopover that is a 
     * round-trip flight.
     */
    public function testYGEtoYGE() {
        $yge_yge_1 = array();
        $yge_yge_2 = array();

        $temp = $this->CI->flightModel->getFlightsByDepart('YGE');
        foreach ($temp as $flight) {
            $temp2[][] = $flight;
        }
        
        $result = $this->CI->flightModel->retrieveFlights($temp2, 'YGE');
        
        $yge_yge_1 = $result['flights'];
        $temp = $result['potential'];
        
        $result = $this->CI->flightModel->retrieveFlights($temp, 'YGE');
        
        $yge_yge_2 = $result['flights'];
        
        //One stopover
        $this->assertEquals('YGE', $yge_yge_1[0][0]['depart']); 
        $this->assertEquals('ZMH', $yge_yge_1[0][0]['arrive']);
        
        $this->assertEquals('ZMH', $yge_yge_1[0][1]['depart']);
        $this->assertEquals('YGE', $yge_yge_1[0][1]['arrive']);
        
        //Two stopovers
        $this->assertEmpty($yge_yge_2);
    }

    /**
     * Test the ability to retreive flights with 2 stopovers.
     */
    public function testYVEtoYYJ() {        
        $yve_yyj_1 = array();
        $yve_yyj_2 = array();

        $temp = $this->CI->flightModel->getFlightsByDepart('YVE');
        foreach ($temp as $flight) {
            $temp2[][] = $flight;
        }
        
        $result = $this->CI->flightModel->retrieveFlights($temp2, 'YYJ');
        
        $yve_yyj_1 = $result['flights'];
        $temp = $result['potential'];
        
        $result = $this->CI->flightModel->retrieveFlights($temp, 'YYJ');
        
        $yve_yyj_2 = $result['flights'];
        
        //One stopover
        $this->assertEmpty($yve_yyj_1);
        
        //Two stopovers
        $this->assertEquals('YVE', $yve_yyj_2[0][0]['depart']);
        $this->assertEquals('ZMH', $yve_yyj_2[0][0]['arrive']);
        
        $this->assertEquals('ZMH', $yve_yyj_2[0][1]['depart']);
        $this->assertEquals('YGE', $yve_yyj_2[0][1]['arrive']);
        
        $this->assertEquals('YGE', $yve_yyj_2[0][2]['depart']);
        $this->assertEquals('YYJ', $yve_yyj_2[0][2]['arrive']);
    }
    
    
    /**
     * Tests to make sure validation does not let a connecting flight leave
     * before the initial flight, and that each flight has at least 30
     * minutes in between.
     */
    public function testCheckTime() {
        $f1 = array();
        $f2 = array();
        $f3 = array();
        $f4 = array();
        
        $f1['depart_time'] = "8:00";
        $f1['arrive_time'] = "10:00";
        
        $f2['depart_time'] = "9:00";
        $f2['arrive_time'] = "11:00";
        
        $f3['depart_time'] = "10:29";
        $f3['arrive_time'] = "11:40";
        
        $f4['depart_time'] = "13:00";
        $f4['arrive_time'] = "15:00";
    
        //Connection leaves after initial, and there is 30 mins in between
        $this->assertTrue($this->CI->flightModel->checkTime($f1, $f4)); 
        //Connection leaves before initial arrives
        $this->assertFalse($this->CI->flightModel->checkTime($f1, $f2));
        //There is only 29 minutes between flights
        $this->assertFalse($this->CI->flightModel->checkTime($f1, $f3));
        //Initial flight departs after connection arrives
        $this->assertFalse($this->CI->flightModel->checkTime($f4, $f2));
    }
}
?>