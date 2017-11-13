<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2016, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller
{

	/**
	 * Constructor.
	 * Establish view parameters & load common helpers
	 */

	function __construct()
	{
		parent::__construct();

		//  Set basic view parameters
		$this->data = array ();
		$this->data['pagetitle'] = 'Goose Airlines';
		$this->data['ci_version'] = (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>'.CI_VERSION.'</strong>' : '';
	}

	/**
	 * Render this page
	 */
	function render($template = 'template')
	{
            //Show the current user on page title
            $role = $this->session->userdata('userrole');
            $this->data['pagetitle'] .= ' ('. $role . ')';
            
            
            // Build the menubar
            $menu_data = $this->config->item('menu_choices');
            //determine the dropdown checkmark
            if($role === ROLE_ADMIN){
                $menu_data['login_checkmark_admin'] = '&#10003;';
            }
            else{
                $menu_data['login_checkmark_admin'] = '';
            }
            if($role === ROLE_GUEST){
                $menu_data['login_checkmark_guest'] = '&#10003;';
            }
            else{
                $menu_data['login_checkmark_guest'] = '';
            }
            $this->data['menubar'] = $this->parser->parse('_menubar', $menu_data, true);

            // Determine the URL this page was requested as
            $this->data['origin'] = $this->uri->uri_string();
            
            $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);
            $this->parser->parse('template', $this->data);
	}

}
