<?php
use PHPUnit\Framework\TestCase;

/**
 * This is a unit test case for plane
 */
class PlaneTest extends TestCase
{
    private $CI;

    protected function setUp()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('fleetModel');
        $this->CI->load->model('wackyModel');
    }
    
    /**
     * unit test for plane type
     */
    public function testPlaneType(){
        $airplanes = $this->CI->wackyModel->airplanes();
        if(count($airplanes) > 0){
            $valid_plane_type = $airplanes[0]['id'];
        }
        $invalid_plane_type = 'invalid invalid invalid';
        
        //pass valid plane type and expect to return true
        $this->assertEquals(true, $this->CI->fleetModel->checkPlaneType($valid_plane_type));
        
        //pass invalid plane type and expect to return false
        $this->assertEquals(false, $this->CI->fleetModel->checkPlaneType($invalid_plane_type));    
    }
    
    /**
     * unit test for budget limit
     */
    public function testBudget(){
        $budget = $this->CI->fleetModel->getBudget();
        $grandtotal = $this->CI->fleetModel->getGrandTotal();
        //expect budget to be greater than zero
        $this->assertEquals(true, $budget > 0, "Budget should be greater than Zero");
        //pass current grand total and expect it to be less than total budget
        $this->assertEquals(true, $budget >= $grandtotal, "Over budget.");
    }
}
?>