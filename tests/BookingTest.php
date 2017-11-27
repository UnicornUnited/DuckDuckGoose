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
    private $flight1;
    private $flight2;
    private $flight3;
    private $flight4;

    protected function setUp()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('flightModel');
        $this->CI->load->model('flight');
        
        $flight1 = array();
        $flight2 = array();
        $flight3 = array();
        $flight4 = array();
    }
    
    /**
     * Tests to make sure validation does not let a connecting flight leave
     * before the initial flight, and that each flight has at least 30
     * minutes in between.
     */
    public function testCheckTime() {
        $flight1['depart_time'] = "8:00";
        $flight1['arrive_time'] = "10:00";
        
        $flight2['depart_time'] = "9:00";
        $flight2['arrive_time'] = "11:00";
        
        $flight3['depart_time'] = "10:29";
        $flight3['arrive_time'] = "11:40";
        
        $flight4['depart_time'] = "13:00";
        $flight4['arrive_time'] = "15:00";
        
        $this->assertTrue($this->CI->flightModel->checkTime($flight1, $flight4));
        $this->assertFalse($this->CI->flightModel->checkTime($flight1, $flight2));
        $this->assertFalse($this->CI->flightModel->checkTime($flight1, $flight3));
        $this->assertFalse($this->CI->flightModel->checkTime($flight4, $flight2));
    }
}
?>