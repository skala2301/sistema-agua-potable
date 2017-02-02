<?php


class Main extends CI_Model {

    
    protected $dir_             = __DIR__;


    public  function __construct() {
         parent::__construct();

         $this->loaders_();//cargamos toda la data necesaria
         $this->frontcontrol->Compute($this  , $this->dir_); //computamos los datos
    }
    
    public function index($status_request = false )
    {



        if(!$this->frontcontrol->Active_())
        {
           // return $this->load->view("errors/frontend/render" , '' , FALSE);
        }

        if($this->frontcontrol->Maintent_())
        {
           // return $this->load->view("mainten/frontend/frontend" , '' , FALSE);
        }


      //  echo $this->frontcontrol->JsonConfig();

        // return $this->load->view("test/hello" , '' , $status_request );

    }
    
    public function action($data = array() , $hello)
    {
 
    }
    
    
    private function loaders_(){
        $this->load->database();
        $this->load->library([ "frontcontrol" ]);
    }

    /*public function dothat(){
        echo "HOLA MUNDO DESDE UNA RUTA";
    }*/
    

}
