<?php

/**
 * @todo  ADMIN CORE 
 * @version 1.0.2
 * @author Rolando Arriaza 
 * @access public
 * @category CORE
 * @uses
 * 
 *  ADMIN CORE se encarga de controlar todo lo relacionado 
 *  con el sistema desde logueo hasta las cuentas que se manejaran 
 * 
 *  la libreria es bastante importante si no tiene conocimiento , favor no altere
 *  el codigo ya que eso podria ocacionar daños irreparabes del sistema
 * 
 * ***/



//INTERFAZ CORE MOTOR 1.0.0
get_instance()->load->interfaces("Interface");

class Test extends CI_Model implements CoreInterface {


    public function __construct() {
        parent::__construct();
    }


    
    public function _actionScriptDashboard() {
        
    }

    public function _actionScript() {
        
    }

    public function _css() {
        return [
             "<style>p{ color : red; }</style>",
            array("http://i.css" , "http://2.css" , "text/css20" => "http://i3.css"),
            "<style>b{ font-size: 4em; }</style>"
        ];
    }

    public function _render($params = NULL) {


       // $a = isset($_REQUEST['hola']) ? $_REQUEST['hola'] : NULL;
       // echo "#Entrando al test mode " , $a ;

        echo get_cookie("lang");

       // return  $this->load->view("test/hello" , [] , true);
        //$this->load->view("test/hello" );
    }

    public function _javascript() {
        return array(
            array("type" => "text/babel" , "location" => "header" , "script" => "http://localhost/pruebascript.js")
        );
    }

    public function _privileges() {
        return NULL;
    }

    public function _title() {
        return "HOLA MUNDO";
    }

    public function _actions() {
        
    }

  

}
