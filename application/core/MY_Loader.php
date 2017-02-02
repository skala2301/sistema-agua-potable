<?php
/**
 * @todo CODEIGNITER EXTENDS LOADER
 * @version 1.0.0
 * @author Rolando Arriaza
 **/
class MY_Loader extends CI_Loader {

    //variables
    protected $_ci_module_paths     = NULL;
    protected $_ci_modules          = NULL;

    /**
     * @todo construct to loader class
     * @version 1.0.0
     * @author Rolando Arriaza
     **/
    public function __construct() {
        parent::__construct();
        $this->_ci_module_paths = APPPATH . "/plugins";
    }

    /**
     * @todo interface
     * @version 1.0.0
     * @author Rolando Arriaza
     **/
    public function interfaces($interface){
        require_once APPPATH . "/interfaces/$interface" . ".php";
    }

    /**
     * @todo complement
     * @version 1.0.0
     * @author Rolando Arriaza
     **/
    public function complement($complement_name){
         require_once APPPATH . "/complement/$complement_name" . ".php";
    }

    /**
     * @todo plugin loader
     * @version 1.0.0
     * @author Rolando Arriaza
    **/
    public function  plugin($module, $pseudo = null)
    {

        $instance = &get_instance(); //get instance to plugin directory

        $part       = explode("/" , $module); // part module
        $name       =  end($part); // name of module end of array

        $this->interfaces("PluginInterface"); // include de interface file

        require_once($this->_ci_module_paths . "/$module" . ".php"); //include the module

        $instance->$name = new $name(); // instance the module
        $this->_ci_modules[] = ($pseudo == null) ? $name : $pseudo; //add module to lib ci

        return $this; // ok return

    }
    
    public function controllers($controller){
        require_once APPPATH . "/controllers/$controller" . ".php";
    }
    
    public function templates($template){
        $path =  APPPATH . "/templates/$template" . ".php";
        if(file_exists($path)){
            return file_get_contents($path);
        }
    }
 
}
