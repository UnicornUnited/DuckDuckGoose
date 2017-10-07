<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fleet extends Application
{
    private $template_filepath_header = '/header';//header template filepath
    private $template_filepath_footer = '/footer';//footer template filepath
    /**
     * Ctor
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper("url");//load the url helper
        $this->load->library('parser');//load the template parse library
        $this->load->model("fleetModel");//Load the model fleet
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
        //generate the plane items data
        $plane_items = array();
        //loop to generate template data
        foreach ($this->fleetModel->all() as $id => $item) {
            $anchor = anchor('/fleet/plane/'.$id, $id, array('title' => $id));
            $plane_items[] = array(
                'plane_id' => $id,
                'link_view_plane' => $anchor
            );
        }
        $template_data = array('plane_items'=>$plane_items);
        
        //parse the plane list template.
        $this->parser->parse('/fleet/plane_list', $template_data);
    }

    function plane($id=""){
        //entry validation check
        if(empty($id)) {
            redirect('/fleet');
            return;
        }
        $template_data = $this->fleetModel->get($id);
        //data validation check
        if(count($template_data)===0){
            redirect('/fleet');
            return;
        }
        $template_data['id'] = $template_data['key'];
        
        //add header template
        $template_data['template_header'] = 
                $this->parser->parse($this->template_filepath_header, 
                        $template_data);
        
        //add footer template
        $template_data['template_header'] = 
                $this->parser->parse($this->template_filepath_footer, 
                        $template_data);
        
        //render this page
        $this->parser->parse('/fleet/plane_item', $template_data);
    }
}
