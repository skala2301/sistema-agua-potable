<?php


/**
 * @todo ROUTES: PARA EL SISTEMA MVA 
 * @version 1.0
 * @author Rolando Arriaza <rolignu90@gmail.com>
 * @copyright (c) 2015, Rolando Arriaza
 * 
 * --------------------------------------------------------
 * 
 * INICIATIVA CLASE ROUTES :
 * 
 *          ESTA CLASE FUE CREADA DADA LA PROBLEMATICA EN LAS VISTAS
 *          DE LAS DIRECCIONES O URL , ESTO AYUDA A LA SEGURIDAD A ESCONDER
 *          LA RUTA ORIGINAL EN EL MVA A UNA RUTA MAS "BONITA"
 * 
 *          LAS RUTAS EN VEZ DE VER ASI : /0/mode=name_model
 *                                        SERA ASI:
 *                                        /0/HelloPrettyRoute
 * 
 * VERSION 1.0:
 * 
 *          PRIMERAS FUNCIONES 
 * 
 *                      get() , set() , push() , pop()
 * 
 * **/

class Routes {
    
    
    protected  $MVA_ROUTES  = [];
    
    protected  $Path        = NULL;
    
    protected  $Object      = NULL;
    
    protected  $Json        = NULL;

    public function __construct() {
        
          //DONDE SE GUARDA LA CONFIGURACION DE LAS RUTAS 
          $this->Path = APPPATH . "config/MVA_ROUTES.json";
          
          //INICIAMOS EL ARREGLO COMO VACIO
          $this->MVA_ROUTES   = [];
          
          //VERIFICAMOS SI EXISTE EL ARCHIVO DE CONFIGURACION RUTAS
          if(!file_exists($this->Path)){
              $d =fopen($this->Path, "w");
              fwrite($d, "[]");
              fclose($d); 
          }
          
          //OBTENIENDO VALORES JSON Y OBJECT
          $data             = file_get_contents($this->Path);
          $this->Json       = $data;
          $this->Object     = json_decode($data , TRUE);


          //VERIFICAMOS SI EL JSON ES UN OBJETO 
          if(sizeof($this->Object) == 0 || $this->Object == NULL){
              return;
          }

            //ROUTES
          $this->MVA_ROUTES = $this->Object;

         
    }
    

    public function Get($name = NULL)
    {
        
        if(!is_null($name))
        {
            if(isset($this->MVA_ROUTES[$name]))
            {
                return $this->MVA_ROUTES[$name];
            }
            else
            {
                $class          = &get_instance();
                $class->load->library("navbar");
                $nav_route      = $class->navbar->get_NavLocation($name) ?? $name;
                return $nav_route;
            }
        }

        return NULL;
    }
    
    public function Set($model  , $name)
    {
        //INGRESAMOS UN MODEL DE FORMA ESTATICA AL ARREGLO GENERADO 
        $this->MVA_ROUTES[$name] = $model;
        return $this;
    }
    
    public function Push($model , $name){

         $this->MVA_ROUTES[$name] = $model;
         file_put_contents(
                 $this->Path, 
                 json_encode($this->MVA_ROUTES)
        );
        return $this;
    }



    /**
     * @author Rolando Arriaza
     * @version 1.0
     * @date 08-09-2016
     * @param string $name route name or shortcode
     * @param object $object object routes speficic
     *
     *                  example :
     *
     *                           $object = new stdclass();
     *                           $object->dir           = "your-direction"
     *                           $object->model         =
     *
     *   "front-test":   ===> nombre corto
                {
                    "dir"     : "frontend",   ==> directorio
                    "model"   : "main",       ==> modelo
                    "action"  : "dothat"      ==> accion o funcion
                }
     *
    **/
    public function PushObject($name , object $object)
    {
        $this->MVA_ROUTES[$name] = json_encode($object);
        file_put_contents(
            $this->Path,
            json_encode($this->MVA_ROUTES)
        );
        return $this;

    }


    
    public function  Pop($name){

        unset($this->MVA_ROUTES[$name]);
        file_put_contents(
                 $this->Path, 
                 json_encode($this->MVA_ROUTES)
        );
        return $this;
    }


   
}
