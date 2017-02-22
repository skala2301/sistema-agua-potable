<?php

class Profile_functions extends  CI_Model
{

    private $query          = NULL;

    private $dpto_table     = NULL;

    private $rol_table      = NULL;

    private $user_table     = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->dpto_table   = $this->db->dbprefix("departments");
        $this->rol_table    = $this->db->dbprefix("rols");
        $this->user_table   = $this->db->dbprefix("user");
    }




    public function new_user(array $dt){
         $this->db->insert($this->user_table , $dt);
         return $this->db->affected_rows();
    }


    public function get_rols(){
        $this->query = "SELECT * FROM $this->rol_table ";
        return $this->db->query($this->query)->result();
    }


    public function get_data_user($id)
    {
        $this->query = "SELECT data as 'data' FROM $this->user_table WHERE id LIKE ?";
        $result = $this->db->query($this->query , [$id])->result()[0] ?? NULL ;

        if(is_null($result)) return NULL;


        return json_decode($result->data);
    }



    public function update_user($data, $id )
    {

        $data_user          = $this->get_data_user($id);
        $data_sender        = [];

        foreach ($data as $value){
            $data_sender[$value['name']] = $value['value'];
        }

        $data_user->details->occupation = $data_sender['occupation'];
        $data_user->details->location   = $data_sender['departments'];

        return $this->db->update($this->user_table , [
            "data"      => json_encode($data_user),
            "email"     => $data_sender['email']

        ] , [ "id" => $id ]);


    }

    public function update_state($state , $id)
    {

        return $this->db->update($this->user_table , [
            "active"      => $state ,
        ] , [ "id" => $id ]);

    }


    public function get_users_names()
    {
        $this->query = "SELECT username as 'user' FROM $this->user_table ";
        return $this->db->query($this->query)->result();
    }

    public function get_users_email($email ){
        $this->query = "SELECT count(*) as 'count' FROM $this->user_table WHERE email LIKE ?";
        return $this->db
            ->query($this->query, [ $email ])
            ->result()[0]->count;
    }


    public function exist_user($user_compare)
    {
        $users = $this->get_users_names();
        foreach($users as $data)
        {
            if(strcmp($user_compare , $data->user) == 0)
                return true;
        }
        return false;
    }


  


}