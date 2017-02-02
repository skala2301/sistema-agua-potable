<?php

/**
 * @@author Rolando Arriaza <rolignu90@gmail.com>
 * @@version 1.0.1
 * @@since 1.0.0
 * 
 * @@Todo Login 
 * 
 *          libreria login , esta libreria llama distintos 
 *          aspectos que conforman el login estos pueden ser funciones
 *          derivadas de la configuracion .json 
 * 
 *          la configuracion .json esta alojada en: conten/system/core/files/
 * 
 *                  el archivo se llama login_resources
 * 
 *         este archivo de tipo mime .json lleva la configuracion 
 *          desde el tema de login hasta cada css y js configurado para 
 *          el correcto funcionamiento.
 * 
 * 
 * ***/

class Login extends CI_Loader  {
    
    
    //variable de directorio configuracion general ... 
    protected $config_dir   = "";
    
    //variable de error , tipo de error 0 y 1
    protected $error        = 0;
    
    //variable de decodificacion json
    private $decode         = NULL;


    private $class;
    
    
    /***
     * Hagamos un contructor heredado del loader
     * **/
   
   public function __construct() {
       parent::__construct();

       $this->class = &get_instance();
       $this->config_dir = $this->class->config->item("login_core");
       
       if(!file_exists($this->config_dir))
       {
           $this->error = 1;
           return;
       }
       
       $file                = file_get_contents($this->config_dir);
       $this->decode        = json_decode($file);
       
   }
   
   
   /**
    * @todo  esta funcion es como llamemos a las demas funciones por medio de un parametro
    * @version 1.1.0
    * @param String $class [ themes , addons , css , js ]
    * @return mixed devuelve un array object si todo bien o un valor false si no 
    * **/
   public function _get($class)
   {
       if($this->error == 1) return FALSE;
       
       switch ($class)
       {
           case "themes":
               return $this->get_themes();
           case "addons":
               return $this->get_addons();
           case "css":
               return $this->get_css();
           case "js":
               return $this->get_js(); 
       }
       
       return false;
       
   }
    
   
   /**
    * @version 1.0.0
    * @return array/object devuelve un arreglo de objetos de los temas 
    * **/
   public function get_themes()
   {
       if($this->error == 1) return FALSE;
       
       return $this->decode->themes;
       
   }
   
   
   public function get_activate_theme()
   {
        if($this->error == 1) return FALSE;
      
        foreach($this->decode->themes as $theme)
        {
            if((int)$theme->activate  == 1)
            {
                return $theme;
            }
        }
        
        return NULL;
   }
   
   public function get_theme_css($theme_id)
   {
       $css = $this->decode->css;
       foreach($css as $object)
       {
           if((int) $object->theme_id == $theme_id)
           {
               return $object->data;
           }
       }
       
       return null;
   }
   
   
   public function get_css()
   {
       if($this->error == 1) return FALSE;
       return $this->decode->css;
   }
   
   public function get_js()
   {
       if($this->error == 1) return FALSE;
       return $this->decode->js;
   }
   
   
    public function get_theme_js($theme_id)
   {
       $js = $this->decode->js;
       foreach($js as $object)
       {
           if((int) $object->theme_id == $theme_id)
           {
               return $object->data;
           }
       }
       
       return null;
   }
   
   public function get_addons()
   {
        if($this->error == 1) return FALSE;
       return $this->decode->addons;
   }
   
}
