<?php


class Tools_devices extends CI_Model implements Generic
{

    var $tables = null ;

    public function __construct()
    {
        parent::__construct();
        $this->Load_();
    }

    public function Load_($objects = null)
    {
        // TODO: Implement Load_() method.
        $this->load->database();
        $this->tables->meta = $this->db->dbprefix("metadata");
    }

    public function Push_(... $data)
    {
        // TODO: Implement Push_() method.
    }

    public function Pull_(... $params)
    {
        // TODO: Implement Pull_() method.
    }

    public function Request_(... $params)
    {
        // TODO: Implement Request_() method.
    }

    public function Object($object = null)
    {
        // TODO: Implement Object() method.
    }


    public function find_packages($name = null ){
        if($name === null )
            $name = $this->input->post("package");


    }

}