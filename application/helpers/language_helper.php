<?php


if (!function_exists("meta_lang")) {

    /**
     * @todo Funcion de multilenguaje de forma metadatos 
     * @version 2.2.1
     * @since 1.0
     * @author Rolando Arriaza <rolignu90@gmail.com>
     * @param string $type lenguaje 
     * @param array $object arreglo de datos ["a" , "b" , "c"] hace referencia a  json jerarquia 
     * 
     * <code>
     * 
     * {
     *  a: {
     *          b: {
     *              c: "LANGUAJE"
     *          }
     *      }
     * }
     * </code>
     * 
     * @param string $file archivo a llamar , por defecto es lang que hace llamado a lang.json
     * @copyright (c) 2016, Rolignu
     * @lastversion 16-07-16
     * */
    function meta_lang($type, $object, $file = "lang" ,  $params = array()) {


        $instance = &get_instance();

        $instance
                ->load
                ->library("Session");
        

        $debug = $instance
                    ->config
                    ->item("lang_debug");
        
        
        $another_file = explode("/", $file);
        

        if(count($another_file) >= 2)
        {
            $directory = $file;
        }
        else
        {
            $directory = $instance->config->item("app_lang");
        }




        /**
         * DEBUG MODE
         * TURN OFF ONLY IF YOUR APP FINISH
         **/


        ;

        $action = FALSE;
        if (!file_exists($directory)) {
            $lang = json_decode($directory);
            return NULL;
        }
        else{
            $language = @file_get_contents($directory);
            if(is_null($language) || empty($language))
            {
                return NULL;
            }
            $action = TRUE;
        }


        if (!$debug) {

            if (!$instance->session->has_userdata("languaje")) {
                $instance->session->languaje = $language;
            }
        }


        if($action == TRUE)
                $lang = json_decode($language);

        if(!isset($lang->$type)) return null;
        else $lang = $lang->$type;

        $object = (object) $object ?? NULL;

        if($object == NULL) return NULL;


        foreach ($object as $obj)
        {
            $forward    = trim($obj);
            $lang = $lang->$forward ?? null;
            if(is_null($lang)) return null;
        }

        if(sizeof($params) !== 0)
        {
            foreach($params as $key=>$value)
            {
                if(strpos($lang , $key) != false)
                {
                    $lang = str_replace($key , $value , $lang);
                }
            }
        }
        
        return $lang;

    }
}


/**
 * @todo Funcion de multilenguaje
 * @version 2.0
 * @author Rolando Arriaza <rolignu90@gmail.com>
 * @copyright (c) 2016, Rolignu
 * * */
if (!function_exists("lang_")) {

    function lang_($object , $params = array()) {
        $instance       = &get_instance();
        $file           =  "." . $instance->config->item("setup_")['lang'];
        return meta_lang($_COOKIE['lang'] ?? 'en' , $object , $file);
    }

}



if(!function_exists("core_lang"))
{
    function core_lang($object , $params = array())
    {

        $instance       = &get_instance();
        $core_file      = "." . $instance->config->item("core_lang");
        $primary_lang   = backend_session_lang() ?? get_lang();
        return meta_lang( $primary_lang, $object , $core_file , $params  );
    }

}


if(!function_exists('get_lang'))
{
    function get_lang()
    {
        return $_COOKIE['lang'] ?? 'es';
    }
}