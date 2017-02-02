<?php

/**
 * Created by PhpStorm.
 * User: Rolando
 * Date: 22/01/2017
 * Time: 11:36 PM
 */
class Looking extends  CI_Model
{

    public function  __construct()
    {
        parent::__construct();
    }


    public function index($status_request = false)
    {

        return $this->load->view("frontend/looking/looking" , [
            "data"  => $this->session->flashdata("looking")
        ] , $status_request);
    }

}