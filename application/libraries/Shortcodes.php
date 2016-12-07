<?php

/**
 * @todo SHORTCODE LIBRARY | Create shortcode parameters s
 * @Version 1.5
 * @year 2016
 * @author Rolando Arriaza <rolignu90>
**/

class Shortcodes
{


    //the view param
    private $view           = NULL;

    //regular expression represent to [function ; var1 ;var2 ;var3 ; ...]
    private $regex          = "/\[(.+?)\]/";

    //regular expression represent a tag to have a function
    private $regex_tag      = "/\{[$](.+?)\}/";

    //routes to call widgets or shortcodes render
    private $routers        = NULL;


    public function __construct()
    {
        $this->routers                      = new stdClass();
        $this->routers->widgets             = APPPATH .  "helpers/widgets_helper.php";
        $this->routers->language            = APPPATH .  "helper/language_helper.php";

        if(!file_exists($this->routers->widgets))
        {
            $this->routers->widgets = NULL;
        }
    }

    /**
     * @version 1.0.0
     * @author Rolando Arriaza
     * @param mixed $view
     * @return $this
    ***/
    public function set($view)
    {
        $this->view = $view;
        return $this;
    }

    /***
     * @author Rolando Arriaza
     * @version 1.4.3
     * compute all type of shortcodes
    */
    public function compute()
    {
        if($this->view == NULL  || $this->view == '')
            return $this->view;


        //verificamos con el pregmatch
        $matches        = NULL;
        $matches_tag    = NULL;

        //verificamos si el patron es correcto
        $is             = preg_match_all($this->regex , $this->view , $matches);

        //tag matches
        $is_tag         = preg_match_all($this->regex_tag , $this->view, $matches_tag);


        //hoy verificamos si existe el patron alguna vez en el contexto

        if(!$is && !$is_tag)  return $this->view;

        //verificamos la ruta widgets
        if($this->routers->widgets != NULL)
        {
            //llamada de la primea busqueda
            $this->widgets($matches);
            //match  tag loop
            if(count($matches_tag[1]) === 1)
            {
                $this->tags($matches_tag[1][0], $matches_tag[0][0]);
            }else {
                for ($i = 0; $i < count($matches_tag[1]); $i++){
                    $this->tags($matches_tag[1][$i], $matches_tag[0][$i]);
                }
            }
        }

        //devuelve la vista ya con los datos generados
        return $this->view;

    }

    /**
     * @version 1.0.0
     * @author Rolando Arriaza <rolignu90@gmail.com>
     * @param $array
     ***/
    public function widgets($array)
    {

        //vemos los codigos generados por el patron
        $codes = $array[1] ?? array();
        //vemos el patron de forma simple o cadena normal
        $preg  = $array[0] ?? array();

        //comienza el bucle de busqueda
        foreach ($codes as $key => $code)
        {
            //patron inicial el punto y coma
            $code  = explode(";" , $code);
            //hacemos limpieza de caracteres en blanco
            $code  = str_replace(" " , "" , $code);

            //verificamos si es un arreglo lo entregado
            if(is_array($code))
            {
                //verificamos si existe la funcion de llamada
                //ojo puede llamar cualquier funcion dentro del contexto helper
                // y claro esta previemente instanciado o autoloader asi que no se limita solo a widgets
                if(function_exists($code[0]))
                {

                    //data como objeto
                    $data                   = new stdClass();
                    //funcion a llamar
                    $data->function         = $code[0];
                    //parametros si es que existen
                    $data->params           = NULL;

                    //buscamos los aprametros por medio de patrones
                    // patrones asignados como $1=valor $1=valor o json simple
                    for ($i = 1 ; $i < count($code) ; $i++)
                    {

                        $variable = explode("=" , $code[$i]);
                        if(count($variable) >= 2)
                        {
                            print_r(compact([$variable[0] => $variable[1]] ));
                            $data->params[] = $variable[1];
                        }
                        else
                        {

                            $variable = $variable[0] ?? $variable;
                            $object   = json_decode( "[" .  $variable . "]");
                            $data->params[] = $object;
                        }



                    }

                    //si solo es un aparametro eliminar el array asociado nivel 2 a nivel 1
                    if(count($data->params) <= 1)
                    {
                        $data->params = $data->params[0];
                    }

                    //callable , llamada de la funcion en el ambito de php
                    $callable   = ! is_null($data->params) ? call_user_func($data->function , $data->params)
                                                           : call_user_func($data->function);
                    //remplazamos la funcion callable en la posicion del shortcode
                    $this->view = str_replace(
                                    $preg[$key] ,
                                    $callable, $this->view);
                }
            }
        }

        return NULL;

    }

    /**
     * @version 1.0.4
     * @author Rolando Arriaza <rolignu90@gmail.com>
     * @param $array
     * @param $pattern array
    ***/
    public function tags($array, $pattern)
    {


        //find a tag into the [1][0] array
        $tag        =  $array;

        //return null if tag not exist , this is a last security mode
        if(is_null($tag)) return $tag ;

        //regex tag for array functions
        $is_array = preg_match_all($this->regex , $tag , $matches);


        //function to call
        $function = explode("," , $tag)[0];
        $reflect   = new ReflectionFunction(trim($function));

        //data array or object
        $callable = NULL;
        if($is_array)
        {
            $data_array = explode("," , $matches[1][0]);
            $callable   = $reflect->invokeArgs(array($data_array));
        }
        else{

             $params = explode("," , $tag);
             if(sizeof($params) >= 2)
             {
                 $data_bound = [];
                 for($i = 1 ; $i < count($params) ; $i++ )
                     $data_bound[] = $params[$i];


                 $callable  = $reflect->invokeArgs($data_bound);
             }
             else{
                 $callable = $reflect->invoke();
             }

        }


        $this->view = str_replace($pattern , $callable , $this->view);


    }

}