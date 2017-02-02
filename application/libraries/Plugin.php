<?php

get_instance()->load->interfaces("SystemPlugin");

class Plugin implements SystemPlugin {
    
    var $class                       = NULL;
    
    var $model_                      = NULL;
    
    var $controller_                 = NULL;
    
    protected  $docs                 = array();


    public function __construct() {
        $this->class = &get_instance();
        $this->class->load->helper("file");
        
         
        $m                  = get_dir_file_info(APPPATH . "models/" , false);
        $c                  = get_dir_file_info(APPPATH . "controllers/" , false);
        $this->model_       = $this->SetWrite($m, "models\\");
        $this->controller_  = $this->SetWrite($c, "controllers\\");
    }

    public function _install() {
        
    }

    public function _show() {

      $the_model         = array();
      
      foreach($this->model_ as $model){
          
           $this->class->load->model($model['init']);
           
           $_config     = isset($this->class->$model['name']->_config) 
                                    ? $this->class->$model['name']->_Getconfig() : NULL;
           
           if(is_null($_config)){
                $_config = isset($this->class->$model['name']->_config) 
                                    ? $this->class->$model['name']->_config : NULL;
           }
           
           if(!is_array($_config)){
               continue;
           }
           
           $path_name= explode("/", $model['init']);
           if(!isset($the_model[$_config['id_model']]['section'])){
              $the_model[$_config['id_model']]['section'] = strtoupper(current($path_name));
           }
           
           $the_model[$_config['id_model']][] = array(
                        "model"         => $model['name'],
                        "path"          => $model['init'],
                        "config"        => $_config,
            );
         
           unset($this->class->$model['name']);
      }
        
      return $the_model;
        
    }
    
    public function _unistall($id_model = NULL) {
        
    }

    public function _update($id_model = NULL) {
        
    }
 
    private function ModelInfo(){
        
        $docs   = array();    
       
        foreach ($this->model_ as $m){
             
            $this->class->load->model($m['init']);
         
            $document           = new ReflectionClass($this->class->$m['name']);
            $data               = explode("@@", $document->getDocComment());
           

           $array = array_map(
                function($str) {
                    return str_replace('*', '', $str);
            },$data );
            
           $array = array_map(
                function($str) {
                    return str_replace('/', '', $str);
            },$array );
            
           
            
            $docs[] = array(
                "model"                     => $m['name'],
                "path_model"                => $m['init'],
                "data"                      => $array,
                "controller"                => array(),
                "dependencies"              => array()
             );
            
            unset($this->class->$m['name']);
        }


        return $docs;
    }
    
    private function ControllerInfo(){
        
        $docs           = array();    
        
        foreach ($this->controller_ as $m){
            
            get_instance()->load->controllers($m['name']);
            $class = $m['name'];
            
            $document           = new ReflectionClass($class);
            $data               = explode("@@",$document->getDocComment() );

            
            $array = array_map(
                function($str) {
                    return str_replace('*', '', $str);
            },$data );
            
            $array = array_map(
                function($str) {
                    return str_replace('/', '', $str);
            },$array );
            
            $docs[] = array(
                "controller"                        => $m['name'],
                "path_controller"                   => $m['init'],
                "data"                              => $array
             );
            
            unset($this->class->$m['name']);
        }

        return $docs;
    }
    
    private function SetWrite($data , $type ){
         
         $array_    = array();
        
         foreach ($data as $d){
             
            $name       = explode(".", $d['name']);
            $directory  = NULL;
            
            if(end($name) == "php"){
                $m          = $name[0];
                $v          = explode($type , $d['relative_path']);
                $directory  = end($v);
                
                if(empty($directory)){
                    $array_[] = array(
                        "name"  => $m,
                        "init"  => $m
                    );
                }else{
                    $array_[] = array(
                        "name"  => $m,
                        "init"  =>  str_replace("\\", "/", $directory) . $m
                    );
                }
            }
            
            
        }
        
        return $array_;
    }

   
    


}