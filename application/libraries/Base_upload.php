<?php


/**
 * @author Rolando Arriaza
 * @name $base_upload
 * @version 1.0
 * @copyright (c) 2015
 * @license GPL
 * @todo    libreria en la cual sube un documento o archivo 
 *          es una version mejorada de la liberia actual upload
 *          ya que cuenta con subida multipart sin error alguno 
 *          , multipart es de esta forma
 * 
 * <code>
 * 
 *  <?php echo form_open_multipart("fileupload/upload/"); ?>
      
 *      <input type="file" name="myfile[]"><br>
        <input type="file" name="myfile[]"><br>
        <input type="file" name="myfile[]"><br>
        <input type="submit" value="Upload File to Server">
 * 
    <?php echo form_close(); ?>
 * 
 * con esta libreria se elimina el error de multipart usando 
 * la funcion Do_MultiUpload
 * 
 * </code>
 * @example  
 *  <code> 
 *      $this->load->library('base_upload');
 *      $this->base_upload->the_function();
 * 
 *  </code>
 * 
 */



class Base_upload  {
    
    /**
     * @var instancia de la clase
     */
    var $class      = NULL;
    
    /**
     * @var array configuracion general del sistema
     */
    var $config     = array();
    
    /**
     * @var array detector de errores , se registran en este arreglo
     */    
    var $error      = array();


    /**
     *@author Rolando Arriaza
     *@version 1.0
     *@todo Constructor de la aplicacion
     */
    public function __construct( array $config = array()) {
        $this->class = &get_instance();
        $this->class->load->library("upload");
        
        if(!empty($config)){
           $this->config = $config;
           $this->Initialize($this->config);
        }
        
        
        $this->config['upload_path']    = "./";
        $this->config['max_size']       = 450000;
        $this->config['file_name']      = NULL;
    }
    
   /**
     *@author Rolando Arriaza
     *@version 1.0
     *@todo inicia la configuracion del sistema 
     *@param array $config es un arreglo de configuracion igual de CI_UPLOAD 
     */
    public function Initialize(array $config = array()){
        if(!empty($config)){
            $this->class->upload->initialize($config);
        }else{
             $this->class->upload->initialize($this->config);
        }
    }
    
     /**
     *@author Rolando Arriaza
     *@version 1.0
     *@todo configuracion general de upload
     */
    public function Set_config($upload_path ,
            $file_name              = NULL , 
            $max_size               = 45000,
            $file_ext_tolower       = TRUE,
            $overwrite              = FALSE ,
            $encrypt_name           = FALSE,
            $remove_spaces          = TRUE
            )
    {
        $this->config['upload_path']               = $upload_path;
        $this->config['file_name']                 = $file_name;
        $this->config['file_ext_tolower']          = $file_ext_tolower;
        $this->config['encrypt_name']              = $encrypt_name;
        $this->config['remove_spaces']             = $remove_spaces;
        $this->config['max_size']                  = $max_size;
        $this->config['overwrite']                 = $overwrite;
    }
    
     /**
     *@author Rolando Arriaza
     *@version 1.0
     *@todo configuracion general si es imagen el archivo a subir
     */
    public function Set_config_image(
            $max_size       = null,
            $max_width      = null,
            $max_height     = null,
            $min_width      = null,
            $min_height     = null
            )
    {
        $this->config['max_size']               = $max_size;
        $this->config['max_width ']             = $max_width;
        $this->config['max_height']             = $max_height;
        $this->config['min_width']              = $min_width;
        $this->config['min_height']             = $min_height;
    }
    
    
     /**
     *@author Rolando Arriaza
     *@version 1.0
     *@todo establece la ruta donde se guardaran los archivos
     */
    public function set_path($upload_path = "./"){
        $this->config['upload_path']   = $upload_path;
    }
    
    
    
     /**
     *@author Rolando Arriaza
     *@version 1.0
     *@todo establece tamaño maximo del archivo
     */
    public function set_maxsize($max_size ){
        $this->config['max_size']  = $max_size;
    }
    
    
     /**
     *@author Rolando Arriaza
     *@version 1.0
     *@todo establece un nuevo nombre al archivo que se subira
     *@param mixed $file_name este parametro puede ser una cadena o 
      *             un arreglo de cadenas como array( "name1"
      *                                                "name2"
      *                                                "name n"  ) 
     */
    public function set_filename($file_name  ){
        $this->config['file_name']  = $file_name;
    }
    
 
   /**
     *@author Rolando Arriaza
     *@version 1.0
     *@todo comienza a subir un archivo 
     */
    public function Do_upload($file_name){
        $is_ok  =  $this->class->upload->do_upload($file_name);
        if(!$is_ok){
            return array(
                "value" => false , 
                "error" => $this->class->upload->display_errors()
            );
        }else{
            return true;
        }
    }
    
    
     /**
     *@author Rolando Arriaza
     *@version 1.0
     *@todo comienza a subir un archivo multipart sin errores
     */
    public function Do_MultiUpload($file_name){
        
        $_file_array  = $_FILES[$file_name];
        
        $_error       = array();
        
        $_file        = NULL;
        
        $_name        = $this->config['file_name'];
        
        $route        = $this->config['upload_path'];
        
        $count        = 0;
        
        
        for($i =0 ; $i < count($_file_array['name']); $i++)
        {

            $_file[] = array(
                "name"      => $_file_array['name'][$i],
                "type"      => $_file_array['type'][$i],
                "tmp_name"  => $_file_array['tmp_name'][$i],
                "error"     => $_file_array['error'][$i],
                "size"      => $_file_array['size'][$i]
            );

        }
       
        if(is_array($_file)){
            
            foreach ($_file as $value){
                
                $is_ok  = FALSE;

                if($value["size"] >= $this->config['max_size'] ? : 450000){
                    $_error[] = "this file " . $value['name'] . " exceeds the limits";
                }
                if($_name != NULL){
                    
                     
                    $file_extend  = explode('.', $value['name']);
                    $file_extend = end($file_extend);

                    if(is_array($_name)){
                        $is_ok  = move_uploaded_file(
                                        $value["tmp_name"], 
                                        $route . $_name[$count] .  '.' . $file_extend
                                 );  
                        
                        $count++;
                        
                    }else{
                            $is_ok  = move_uploaded_file(
                                        $value["tmp_name"], 
                                        $route . "$_name.$file_extend"
                                );  
                            
                    }
                }
                else{
                    $is_ok =  move_uploaded_file(
                             $value["tmp_name"],  
                             $route . $value['name'] 
                     );  
                }
                
                if(!$is_ok){
                    $_error [] = "this file " . $value['name'] . " no upload to " . $route;
                }

            }
        }else{
            return $this->Do_upload($file_name);
        }
        
        if(count($_error) >= 1){
            $this->error[] = $_error;
            return false;
        }
        
        return true;
    }
    
    
     /**
     *@author Rolando Arriaza
     *@version 1.0
     *@todo obtiene la informacion del archivo que se ha subido
     */
    public function Show_UploadData($file_name){
        return $this->class->upload->data($file_name);  
    }
    
    
     /**
     *@author Rolando Arriaza
     *@version 1.0
     *@todo obtiene los errores en el proceso si existen
     */
    public function Show_Error(){
        return $this->error;
    }
    
 
    
}
