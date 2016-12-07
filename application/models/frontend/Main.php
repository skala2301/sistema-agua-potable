<?php


class Main extends CI_Model {

    
    protected $dir_             = __DIR__;


    public  function __construct() {
         parent::__construct();

         $this->loaders_();//cargamos toda la data necesaria
         $this->frontcontrol->Compute($this->dir_); //computamos los datos
    }
    
    public function index()
    {

        if(!$this->frontcontrol->Active_())
        {
            return $this->load->view("errors/frontend/render" , '' , FALSE);
        }

        if($this->frontcontrol->Maintent_())
        {
            return $this->load->view("mainten/frontend/frontend" , '' , FALSE);
        }

        echo "hola mundo";
    }
    
    public function action()
    {
 
    }
    
    
    private function loaders_(){
        $this->load->database();
        $this->load->library([ "frontcontrol" ]);
    }
    

}
