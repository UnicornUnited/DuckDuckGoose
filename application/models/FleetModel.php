<?php
class Fleet extends CI_Model
{

    // The data is hardcoded to indicate the fleet we've selected.
    var $data = array(
        'caravan' => array('type' => 'Grand Caravan Ex', 'speed' => 340),
        'pc12ng' => array('type' => 'PC-12 NG', 'speed' => 500),
        'phenom100' => array ('type' => 'Phenom 100', 'speed' => 704)
    );

    // Constructor
    public function __construct()
    {
        parent::__construct();

        // inject each "record" key into the record itself, for ease of presentation
        foreach ($this->data as $key => $record)
        {
            $record['key'] = $key;
            $this->data[$key] = $record;
        }
    }

    // retrieve a single plane, null if not found
    public function get($which)
    {
        return !isset($this->data[$which]) ? null : $this->data[$which];
    }

    // retrieve all of the planes
    public function all()
    {
        return $this->data;
    }

}
