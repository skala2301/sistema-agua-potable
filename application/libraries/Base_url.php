<?php defined('BASEPATH') OR exit(' OMG !! Algo pasa');

/**
 * @author Rolando Arriaza
 * @name $Base_session
 * @version 1.0
 * @copyright (c) 2015
 * @license GPL
 * @todo libreria de rutas url
 * @example  
 *  <code> 
 *      $this->load->library('base_url');
 *      $this->base_url->the_function();
 * 
 *  </code>
 * 
 */


class Base_url {
    
    /**
     * @var std/class Variable para instanciar la libreria URL
     */
    var $class      = NULL;
    
   
    /**
     * @author Rolando Arriaza <rolignu90@gmail.com>
     * @todo Constructor de la clase , instancia los objetos necesarios
     * @version 0.1
     * @copyright (c) 2015, Lieison
     */
    public function __construct() {
         $this->class = &get_instance();
         $this->class->load->helper('url');
    }
    
    
    /**
     * @author Rolando Arriaza <rolignu90@gmail.com>
     * @todo funcion que obtiene la url estandar este caso seria http://site.com/index.php?/val1/val2/valn/...
     * @param mixed $dir , directorio para complementar la url , opcional 
     * @version 0.1
     * @copyright (c) 2015, Lieison
     * @return String 
     */
    public function GetUrl($dir = "/"){
          return site_url($dir);
    }
    

    /**
     * @author Rolando Arriaza <rolignu90@gmail.com>
     * @todo funcion que obtiene la url base de la app
     * @param mixed $params parametros de la url como base/todo/list/
     * @version 0.1
     * @copyright (c) 2015, Lieison
     * @return String 
     */
    public function GetBaseUrl($params = NULL){
          return base_url($params);
    }
    
    
    /**
     * @author Rolando Arriaza <rolignu90@gmail.com>
     * @todo Obtiene la direccion donde se llama la funcion actualmente
     * @version 0.1
     * @copyright (c) 2015, Lieison
     * @return String 
     */
    public function GetCurrentUrl(){
        return current_url();
    }
    
    
    /**
     * @author Rolando Arriaza <rolignu90@gmail.com>
     * @todo obtiene una direccion url amigable esto claro si cumple con los estandares
     * @version 0.1
     * @copyright (c) 2015, Lieison
     * @return String 
     */
    public function FriendlyUrl($name , $separator = '-' , $is_lowercase = FALSE){
       return url_title($name, $separator, $is_lowercase);
    }
    
}
