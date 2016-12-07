<?php


class Install {
    
    
    protected  $echema = [
        
        "user"              => "",
        "login"             => ""
        
    ];
    
    var $instance = NULL;


    public function __construct() {
        $this->instance         = &get_instance();
        
        $this->instance
                ->load
                ->helper(["url" , "form" , "string"]);
    }
    
    public function install($installed = FALSE)
    {
        
        switch($installed)
        {
            case FALSE:
                return FALSE;
            case TRUE:
                return TRUE;
        }
    }
    
    private function get_install()
    {
        
    }
    
    private  function get_db_schema()
    {
        
    }
    
   
}
