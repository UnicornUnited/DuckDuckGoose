<?php

/**
 * Controller for the User Roles in the navbar.
 */
class Roles extends Application
{

        public function actor($role = ROLE_GUEST)
        {
            $this->session->set_userdata('userrole',$role);
            redirect($_SERVER['HTTP_REFERER']); // back where we came from
        }

}

