<?php

get_instance()->load->interfaces("Generic");

class Tools_devices extends CI_Model implements Generic
{

    protected $tables                   = null ;

    protected $url_particle             = null ;

    protected $url_photon               = null ;

    protected $querys = [
        "apks" => [
            "is"   => "SELECT count(*) as 'count' FROM [table] WHERE [table].name = ? "
        ],
        "devices" => [
            "find" => "SELECT particle_id as 'particle_id' FROM [table] where particle_id = ? "
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
        $this->load->library("meta");
        $this->tables = new stdClass();
        $this->tables->meta         = $this->db->dbprefix("metadata");
        $this->tables->apk          = $this->db->dbprefix("package");
        $this->tables->device       = $this->db->dbprefix("device");
        $this->url_particle         = $this->meta->get_meta_value("particle_url");
        $this->url_photon           = $this->meta->get_meta_value("particle_photon_get");

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

    public function find_devices($device_id = null ){

        if(is_null($device_id))
            $device_id = $this->input->post("device_id") ?? '' ;

        $query = set_database_query(
            $this->tables->device ,
            "[table]" ,
            $this->querys["devices"]["find"]
        );

        $result = $this->db->query($query ,[$device_id])->result();

        return json_encode($result);
    }

    public function  get_particle_url () { return $this->url_particle; }

    public function  get_photon_url() { return $this->url_photon; }

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

    public function set_package ($name , $id_project   , $privs = null )
    {

        $date = new DateTime("now");
       // $this->db->trans_start();
        $this->db->insert($this->tables->apk , [
            "name"              => $name,
            "active"            => 1,
            "privs"             => $privs,
            "id_project"        => $id_project,
            "start_date"        => $date->format("y-m-d h:m:s")
        ]);
        //$this->db->trans_complete();

        return (object) [
            "status"    => $this->db->affected_rows() >= 1 ? true : false ,
            "id"        => $this->db->insert_id() ?? null
        ] ;
    }

    public function delete_package ($id){
        $this->db->trans_start();
        $this->db->where(["id" => $id]);
        $this->db->delete($this->tables->apk );
        $this->db->trans_complete();
    }


}