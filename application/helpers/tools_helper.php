<?php

/**
 * @@version = 1.0
 * @@author = Rolando Arriaza
 */


defined("CONTENT_CORE") or define("CONTENT_CORE", "content/system/core/");
defined("CONTENT_SYSTEM") or define("CONTENT_SYSTEM", "content/system/");


if (!function_exists("print_css")) {

    /**
     * @version 1.5
     * @param string $format link , url 
     * @param string/array $name nombre del css a llamar
     * @todo  el parametro format dive si imprime en formato link o retorna la url
     * @todo  imprime un valor css predeterminado del sistema
     *        la version 1.1 ya acepta que en una funciona imprima multiples 
     *        estilos o retorne la url de multiples estilos 
     * 
     * */
    function print_css($name, $format = "link") {

        
        

        $instance           = &get_instance();
        $instance->load->helper("url");
        $urls               = [];

        $css_path = FCPATH . CONTENT_SYSTEM . "files/system_css.json";
        

        if (!file_exists($css_path)) {
            return NULL;
        }

        $css_content = file_get_contents($css_path);
        $object = json_decode($css_content);
        

        if (is_array($name)) {

            foreach ($name as $n) {
                
                
                /**
                 * parche para aceptar formato cdn 
                 * o tambien que no este en el contexto de system_css o system_js
                 * ***/
                
                if(count(explode( "/", $n)) >= 2)
                {
                    
                    $match = preg_match('^(http|ftp|https)',$n);
                    if(!$match)
                    {
                     
                        $n = site_url($n);
                    }
                    $urls[] = $n;
                    continue;
                }
                
                
                
                $data = isset($object->$n) ? $object->$n : NULL;
                
                if ($data !== NULL) {
                    
                    $url = "";
                    
                    if(!isset($data->location))
                    {
                        
                        $url = site_url(CONTENT_CORE . "css/global/" . $data->name);
                    }
                    else{
                        
                        $url = site_url( $data->location . $data->name);
                    }
                    
                    
                    switch ($format) {
                        case "link":
                            print '<link id="' . random_string('sha1') . '" rel="stylesheet" type="text/css" href="' . $url . '">';
                            break;
                        case "url":
                            $urls[] = $url;
                            break;
                    }
                }
            }

            return !empty($urls) ? $urls : NULL;
        } else {
            $data = isset($object->$name) ? $object->$name : NULL;
            if ($data !== NULL) {
                $url = site_url(CONTENT_CORE . "css/global/" . $data->name);
                switch ($format) {
                    case "link":
                        print '<link rel="stylesheet" type="text/css" href="' . $url . '">';
                        break;
                    case "url":
                        return $url;
                }
            }
        }


        return NULL;
    }

}
    

if (!function_exists("print_javascript")) {

    /**
     * @version 1.7
     * @param string $format link , url 
     * @param string/array $name nombre del css a llamar
     * @todo  el parametro format dive si imprime en formato link o retorna la url
     * @todo  imprime un valor css predeterminado del sistema
     *        la version 1.1 ya acepta que en una funciona imprima multiples 
     *        estilos o retorne la url de multiples estilos
     *
     * @todo  se agrego multiformato text/babel
     * 
     * */
    function print_javascript($name, $format = "link") {


        $instance = &get_instance();
        $instance->load->helper("url");

        $js_path = FCPATH . CONTENT_SYSTEM . "files/system_js.json";
        $path = FCPATH . CONTENT_CORE . "js/";

        if (!file_exists($js_path)) {
            return NULL;
        }

        $js_content = file_get_contents($js_path);
        $object = json_decode($js_content);

        if (is_array($name)) {

            $urls = [];

            foreach ($name as $n) {
                
                   
                /**
                 * parche para aceptar formato cdn 
                 * o tambien que no este en el contexto de system_css o system_js
                 * ***/
                
                if(count(explode( "/", $n)) >= 2)
                {
                     $unacceptables = array('https:', 'http:' , 'www', "http://");
                    $find = strpos($n, $unacceptables);
                    if($find === FALSE)
                    {
                        $n = site_url($n);
                    }
                    $urls[] = $n;
                    continue;
                }
                
                
                
                $data = isset($object->$n) ? $object->$n : NULL;
                
                
                if ($data !== NULL) {
                    
                    $url = "";
                    
                     
                    if(!isset($data->location))
                    {
                        $url = site_url(CONTENT_CORE . "js/global/" . $data->name);
                    }
                    else{
                        $url = site_url( $data->location . $data->name);
                    }
                    
                    switch ($format) {
                        case "link":
                            $js_type = isset($data->format) ? $data->format :"text/javascript";
                            print '<script type="' . $js_type . '" src="' . $url . '"></script>';
                            break;
                        case "url":
                            $urls[] = $url;
                            break;
                    }
                }
            }

            return !empty($urls) ? $urls : NULL;
            
            
        } 
       
        else {
            $data = isset($object->$name) ? $object->$name : NULL;
            
            if ($data !== NULL) {
                $url = site_url( $data->location .  $data->name);
                switch ($format) {
                    case "link":
                        print '<script type="text/javascript" src="' . $url . '">';
                        break;
                    case "url":
                        return $url;
                }
            }
        }


        return NULL;
    }

}


if(!function_exists("view_url"))
{
    /**
     * @version 1.0
     * @param String $url cadena de la url 
     * @return  String devuelve la url final de donde se encuentra la vista
     * **/
    
    function view_url($url){
         return site_url("application/views/" . $url);
    }
    
}

if(!function_exists("dashboard_url"))
{
    function dashboard_url()
    {
        $intance        = &get_instance();
        $dashboard      = $intance->config->item("backend");
        return site_url($dashboard);

    }
}


if(!function_exists("backend_session_lang"))
{
    function backend_session_lang()
    {
        $intance        = &get_instance();
        $intance->load->library("session");
        $session_name = $intance->config->item("session_lang");
        return $intance->session->$session_name ?? 'es';
    }
}


if(!function_exists("backend_session_lang_set"))
{
    function backend_session_lang_set($lang) : bool
    {
        $intance        = &get_instance();
        $intance->load->library("session");
        $session_name = $intance->config->item("session_lang");
        $intance->session->$session_name = $lang;
        if(backend_session_lang() != NULL) return TRUE;
        else return FALSE;
    }
}

if(!function_exists("memory_convert"))
{
    function memory_convert($size)
    {
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }
}


if(!function_exists("get_memory"))
{
    function get_memory()
    {
        return memory_convert(memory_get_usage(true));
    }
}


if(!function_exists("garrobo_version"))
{
    function garrobo_version()
    {
        $instance = &get_instance();
        return $instance->config->item('garrobo_version');
    }
}


if(!function_exists("ci_version"))
{
    function ci_version()
    {
        return CI_VERSION;
    }
}


if(!function_exists("php_version"))
{
    return phpversion();
}




