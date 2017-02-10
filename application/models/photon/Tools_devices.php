<?php

get_instance()->load->interfaces("Generic");

class Tools_devices extends CI_Model implements Generic
{

    protected $tables = null ;

    protected $querys = [
        "apks" => [
            "is"   => "SELECT count(*) as 'count' FROM [table] WHERE [table].name = ? "
        ]
    ];

    public function __construct()
    {
        parent::__construct();
        $this->Load_();
    }

    public function Load_($objects = null)
    {
        // TODO: Implement Load_() method.
        $this->load->database();
        $this->load->helper(["database"]);
        $this->tables = new stdClass();
        $this->tables->meta         = $this->db->dbprefix("metadata");
        $this->tables->apk          = $this->db->dbprefix("package");

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


    public function find_packages($name = null ) : string {
        if($name === null )
            $name = $this->input->post("package");

        $query = set_database_query($this->tables->apk , "[table]" , $this->querys["apks"]["is"]);
        $count_apks = $this->db->query($query , [$name])
                                ->result()[0]
                                ->count ?? 0;

        if($count_apks == 0 )
            return json_encode([
                "status"    => false ,
                "count"     => 0,
                "name"      => $name
            ]);
        else
            return json_encode([
                "status"    => true ,
                "count"     => $count_apks,
                "name"      => $name
            ]);


        return  json_encode([]) ;

    }


}