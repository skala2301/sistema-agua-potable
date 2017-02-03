<?php

/**
 * @author Rolando Arriaza 
 * @name UserType 
 * @access public
 * @version 1.0
 * @date 16-nov-2016
 * @see http:// 
 * @todo Esta clase se puede heredar y funciona como un catalizador de errores
 *       varios estos pueden ser errores internos de php o de base de datos 
 *       asi dandonos a conocer mejor la relacion en donde hubo causa o daño 
 *       para llegar a una pronta solucion.
 * ---------------------------------------------------------------------------
 *                           ULTIMAS MODIFICACIONES
 *          
 *  Nombre                         Fecha              Comentario 
 * <rolignu>                    <16-nov-2016>        <creacion de la clase>
 *  
 * 
 */


class Systemerror  {
    
    private $error_types = [
        "internal"      => 0,
        "class"         => 1,
        "database"      => 2,
        "frontend"      => 3,
        "backend"       => 4
    ];
    
    private $directory      = './application/logs/errors/';
    
    private $filelog        = NULL;
    
    private $instance       = NULL;
    
    private $fileext        = ".php";
    
    private $full_file      = NULL;
   
    public function __construct($instance = NULL) {
        
        //si existe un ibjeto instanciado en dado caso se instancia la clase CI
        try{
            //posiblemente puede dar error en la clase error :O estar preparados
            $this->instance         = $instance == NULL ? get_instance() : $instance;
            $this->directory        = $this->instance
                                                ->config->item("log_error");
        } catch (Exception $ex) {
           $this->SetError(1 ,
                   'SystemError Class' , 
                   $ex->getMessage() ,
                   $ex->getLine() ,
                   $ex->getFile());
        }
      
    }
    
    public function __destruct() {
        
    }
    
    public function SetError($type , $name  , $message , $line , $file  )
    {
        $this->CreateLog($type , $name  , $message , $line , $file );
    }
    
    
    
    
    private function CreateLog(
            $type = 0 , 
            $name = '' , 
            $message = '' , 
            $line = '' , 
            $file = '' , 
            $user= '' , 
            $data = '' )
    {
        $this->make_dir();
        $this->make_file();
    }
    
    
    protected function make_dir()
    {
        $date           = new DateTime();
        $format         = "log_" . $date->format("Y_m_d");
        $this->filelog  = $format;
        
        if(file_exists($this->directory . $format)){
            return TRUE ;
        }
        
        return @mkdir($this->directory . $format , 0777);
    }
    
    protected function make_file()
    {
        $full_dir = $this->directory . $this->filelog . "/" . $this->filelog  . $this->fileext;
        $this->full_file = $full_dir;
        
        if(file_exists($full_dir))
        {
            return TRUE;
        }
        
        $o = fopen($full_dir, "w+");
        if(!$o) return TRUE;
    }
   
    
}
