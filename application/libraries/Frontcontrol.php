<?php

/**
 * @author Rolando Arriaza
 * @name FrontControl
 * @access public
 * @version 1.0
 * @date 20-nov-2016
 * @see http://
 * @todo esta clase maneja todo lo relacionado con el tipo de usuario
 *
 *
 * ---------------------------------------------------------------------------
 *                           ULTIMAS MODIFICACIONES
 *
 *  Nombre                         Fecha              Comentario
 * <rolignu>                    <20-nov-2016>        <creacion de la clase>
 *
 *
 */


class FrontControl extends SystemError
{

    private $instance           = NULL;

    protected $dir_             = './application/models/';

    protected $config_file      = 'static/static_[model].json'; //default

    protected $active           = FALSE;

    protected $mainten          = NULL;

    protected $json_config      = NULL;


    public function __construct()
    {
        $this->instance = &get_instance();
        parent::__construct($this->instance);

        $this->loaders_(); //cargamos todas las liberias necesarias
    }


    /**
     * @author Rolando Arriaza
     * @name User
     * @access public
     * @version 1.0.0
     * @date 20-nov-2016
     * @see http://
     * @todo Compute se encarga de verificar la interfaz del front end
     *
     *      Ultimas modificaciones :

     * ---------------------------------------------------------------------------
     *                           ULTIMAS MODIFICACIONES
     *
     *  Nombre                         Fecha              Comentario
     *
     *
     */

    public function Compute( $model_name ,   $dir = null )
    {
        //verifica si un directorio no es nulo
        if(!is_null($dir))
        {
            $this->dir_ = $dir;
        }


        //verificamos si existe el documento de configuracion front-end
        //si existe devolvera un object de ese , si no devolvera un false

        if(gettype($model_name) == 'object')
        {
            $model_name = (string) get_class($model_name);
        }


        $this->json_config = $this->instance
                                    ->fileinfo
                                    ->JsonFileDecode(
                                        str_replace("[model]" , $model_name , $this->config_file) ,
                                        $this->dir_
                                    );

        //verificamos la condicion
        if(is_bool($this->json_config)) {
            $this->active = FALSE;      // bandera en el index data
            return false;               // para que seguir cargando si la interfaz del front no existe
        }
        else{
            $this->active = TRUE;
        }

        //modo mantenimiento
        $this->mainten = $this->instance->config->item('mainten_mode');

        return $this;
    }

    public function JsonConfig() : string { return json_encode($this->json_config); }


    public function Active_()
    {
        return $this->active;
    }

    public function Maintent_()
    {
        return $this->mainten;
    }


    private function loaders_()
    {
        $this->instance->load->library(["fileinfo"]);
        $this->instance->load->database();
       // $this->instance->load->helper([]);
    }



}