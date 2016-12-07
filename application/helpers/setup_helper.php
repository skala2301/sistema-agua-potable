<?php


/**
 * Configuracion de la llave AES-256 
 * para encriptacion de las contraseñas
 * **/
if(!function_exists("get_key")){
    function get_key()
    {
        return "APANtByIGI1BpVXZTJgcsAG8GZl8pdwwa84";
    }
}

if(!function_exists("system_debug"))
{
    function system_debug()
    {
        $i = &get_instance();
        return $i->config->item("system_debug");
    }
}


/**
 * Region de configuracion de correo electronico
 * : config
 * : email from config
 * **/

if(!function_exists("email_config")){
    function email_config(){
        
        $i = &get_instance();
        $i->load->library("meta");
        $debug = $i->config->item("email_debug");
        
        if($debug || $i->meta->get_meta_value("smtp_status") == '1')
        {

            $config['protocol']     =   $i->meta->get_meta_value('smtp_protocol')  ?? 'smtp';
            $config['smtp_host']    =   $i->meta->get_meta_value("smtp_host")      ?? 'localhost';
            $config['smtp_port']    =   $i->meta->get_meta_value("smtp_port")      ?? '465';
            $config['smtp_timeout'] =   $i->meta->get_meta_value("smtp_timeout")   ?? '10';
            $config['smtp_user']    =   $i->meta->get_meta_value("smtp_user")      ?? 'root';
            $config['smtp_pass']    =   $i->meta->get_meta_value("smtp_pass")      ?? 'localhost';
        }

         $config['charset']='utf-8';
         $config['newline']="\r\n";
         $config['wordwrap'] = TRUE;
         $config['mailtype'] = 'html';
         
         return $config;
            
    }
}




if(!function_exists('check_plugin'))
{
    function check_plugin(array $plugin)
    {

        if(!is_array($plugin)) return FALSE;

        $instance   = &get_instance();
        $GPATH      = APPPATH;
        $path       = $instance->config->item("setup_")['plugin_dir'];
        $build      = $GPATH . $path . "/[plugin].php" ;

        if(!is_dir($GPATH . "/" . $path)) return FALSE;

        $plugin_instance    = str_replace("[plugin]" , implode("/" , $plugin) , $build);

        if(file_exists($plugin_instance)) return TRUE;

        return FALSE;

    }
}


/**
 * Varios
 */

if(!function_exists("check_model")){
    
    //PARCHE ANALIZADOR SINTACTICO PARA LAMP Y WAMP
    function check_model(array $model){
        
        
        if(count($model) < 2 ){
            return FALSE;
        }
        
        $path1       = APPPATH . "models/" ;
        $path2       = APPPATH . "models/";
        
        if(count($model) == 1){
           $path1 .=  ucwords($model[0]);
           $path2 .=  $model[0];
        }else{
            $path1 .= $model[0] . "/" . ucwords($model[1]);
            $path2 .= $model[0] . "/" . $model[1];
        }
 
        if(file_exists( $path1 . ".php")){
            return TRUE;
        }else
        {
            if(file_exists($path2 . ".php")){
                return TRUE;
            }
            
            return FALSE;
        }
    }
}




if(!function_exists("internet_conection")){
    function internet_conection(){
        if(!@fsockopen("www.google.com", 80)){
            return FALSE;
        }else{ return TRUE; }
    }
}
