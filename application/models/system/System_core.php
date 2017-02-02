<?php


get_instance()->load->interfaces("Interface");
class System_core extends CI_Model implements CoreInterface
{

    /**
     * @todo inicia todos los componentes necesarios
     *       esto pueden ser librerias , helpers y las vistas
     * @return null no debe de retornar un valor ya que no se tomara en cuenta
     */
    public function _render($params = NULL)
    {
        // TODO: Implement _init() method.
    }


    public function Error404($type = "server")
    {
        switch ($type)
        {
            case "server":
                $this->load->view($this->config->item("view_errors")['404_'] , [
                    "enabled"       => false,
                    "request"       => "back"
                ]);
                break;
            case "json":
                return $this->load->view($this->config->item("view_errors")['404_'], [
                    "enabled"       => true,
                    "request"       => "back"
                ] , TRUE);
                break;
        }
    }

    public function denied($type = "server")
    {
      switch ($type)
      {
          case "server":
              $this->load->view($this->config->item("view_errors")['denied'] , [ "enabled" =>  false ] );
              break;
          case "json":
              return $this->load->view($this->config->item("view_errors")['denied'],[ "enabled" => true ] , TRUE);
              break;
      }
    }

    /**
     * @todo establece todas las dependencias css dentro del header
     * @return array , devuelve un arreglo con las direcciones de los css
     *
     */
    public function _css()
    {
        // TODO: Implement _css() method.
    }

    /**
     * @todo establece todas las dependencias js dentro del footer
     * @return array , devuelve un arreglo con las direcciones de los js
     *
     */
    public function _javascript()
    {
        // TODO: Implement _javascript() method.
    }

    /**
     * @todo establece funciones javascript dentro de DOM init o document.ready
     * @return array , devuelve un array donde iran las funciones
     * @example  arra("funcion1();" , "var func = function(){}" , ...);
     *
     */
    public function _actionScript()
    {
        // TODO: Implement _actionScript() method.
    }

    /**
     * @todo establece el titulo dentro del header
     * @return string , solo devuelve una cadena ...
     *
     */
    public function _title()
    {
        // TODO: Implement _title() method.
    }

    /**
     * @todo funcion que requiere el nivel de seguridad de acuerdo a los roles
     * @return string/null/array , retorna un nivel , ninguno  o varios
     */
    public function _privileges()
    {
        // TODO: Implement _privileges() method.
    }

    /**
     * aca se carga todo lo que iniciara eventualmente en el dashboard
     * por medio de un proceso en segundo plano js
     */
    public function _actionScriptDashboard()
    {
        // TODO: Implement _actionScriptDashboard() method.
    }

    /**
     * actions es una funcion interfaz en cual verifica todas la acciones del sistema
     */
    public function _actions()
    {
        // TODO: Implement _actions() method.
    }


    public function gasidebar($type = "object")
    {

        $type = $_GET['type'] ?? "object";

        $this->load->library("navbar");

        return $this->navbar
                    ->GetNav((object) [
                        "privs" => true ,
                        "json" => ($type == "json" ? true : false) ,
                        "type" => "sidebar"
                    ])
                    ->get_siderbar_result();

    }
    
    public function Menu ($type = "object"){
        
        $type = $_GET['type'] ?? "object";

        $this->load->library("navbar");

        return $this->navbar
                    ->GetNav((object) [
                        "privs" => true ,
                        "json" => ($type == "json" ? true : false) ,
                        "type" => "sidebar"
                    ])
                    ->get_menu_result();
        
    }


    public function get_langs() : string
    {
        return json_encode($this->system->get_CoreLang());
    }



    /**
     * @author Rolando Arriaza
     * @name get_looking
     * @access public
     * @version 1.0.0
     * @date 23-jan-2017
     * @see http://
     * @return boolean
     * @todo funcion de llamada a front end desde la vista 404_error.php
     *       por medio de una peticion post en el formulario por medio
     *       del MVA Dashboard/Request
     *
     *      Ultimas modificaciones :
     *
     *          --- esta funcion se encarga de buscar en todas las paginas del front
     *              las palabras claves asignadas por el usuario y cuando las encuentra
     *              entonces redirecciona la pagina al modelo looking asignando a la vez una
     *              sesion de tipo flash la cual ayudara a eniar la data resultado como si fuera post.
     *              su valor de retorno es un booleand
     *
     *
     * ---------------------------------------------------------------------------
     *                           ULTIMAS MODIFICACIONES
     *
     *  Nombre                         Fecha              Comentario
     * <rolignu>                    <23-nov-2016>        <modificacion clase>
     *
     *
     */
    public function get_looking() : bool
    {
        $word           = $this->input->post("look") ?? NULL;
        $request        = $this->input->post("request") ?? NULL;

        if(is_null($word) || empty($word))
        {
            if(is_null($request))
                redirect(site_url());
            else
                redirect(dashboard_url());
            return false ;
        }


        $this->load->library("tools");
        $files              = array();


        switch ($request)
        {
            case NULL:
            case "front":
                    $front = $this->config->item("base_directories")['front']['name'];
                    $files = $this->tools->get_models_files($front);


            $counter = 0;
            $data = [];
            foreach ($files as $file )
            {
                $model = $this->tools->convert_starting_path( "models/" , $file->path);
                $model .= "/" . str_replace(".php" , "" , $file->lower_name);


                $callname = "callable" . $counter;
                $this->load->model($model , $callname );
                $methods            = get_class_methods($this->$callname);

                foreach($methods as $method)
                {
                    $rclass             = new ReflectionClass($this->$callname);


                    if($rclass->getMethod($method)->isPublic()
                        && !$rclass->getMethod($method)->isConstructor()
                        && !$rclass->getMethod($method)->isDestructor()
                        && !$rclass->getMethod($method)->isInternal()
                        && !$rclass->getMethod($method)->isGenerator()
                        && !$rclass->getMethod($method)->isClosure()
                        && !$rclass->getMethod($method)->isStatic()
                        && !$rclass->getMethod($method)->isVariadic()
                    )
                    {
                        if($method != "__get")
                        {
                            $args      = $rclass->getMethod($method)->getParameters();
                            $optional  = false;
                            $count = -1;
                            foreach ($args as $c => $arg )
                            {
                                if($arg->isOptional())
                                {
                                    $optional = true;
                                    $count = 0;
                                    break;
                                }
                            }

                            if($optional && $count == 0)
                            {
                                $view      = $this->$callname->$method(true);
                                $explode   = explode(" " , $word);
                                $pattern   = '/' . $word . '/';

                                if(count($explode) >= 2)
                                {
                                    $pattern = "/";
                                    foreach ($explode as $k => $w)
                                    {
                                        $pattern .= "$w";
                                        if($k !== count($explode)- 1)
                                                $pattern .= "|";
                                    }
                                    $pattern .= '/';
                                }

                                $end = null ;
                                $result     = preg_match_all($pattern , $view , $end , PREG_PATTERN_ORDER );

                                if($result >= 1  && !is_null($result))
                                {
                                    /***
                                     * data se le pasara los resultados de
                                     * la busqueda para front end
                                     *
                                     *  !/(:any)/(:any)/(:any)
                                     ****/

                                    $route      = $this->config->item("frontend")->prefix;
                                    $parts_     = explode("/", $model);
                                    $function   = $method;

                                    $redirect = "";
                                    if(sizeof($parts_) <= 1)
                                    {
                                        $redirect = ($route . "/" . $parts_[0] . "/"  . $function . "/" );
                                    }
                                    else{
                                        $redirect = ($route . "/" . $parts_[1] . "/"  . $function . "/" . $parts_[0]);
                                    }


                                    $find       = array();
                                    $not_find   = array();

                                    /**
                                     * algoritmo de busqueda de palabras encontradas
                                     * y no encontradas.
                                     * este algoritmo tiene complejidad O(N^3)
                                     *      en un futuro modificar para llegar a ser o(n)
                                     *      Rolando Arriaza tubo weba lo hizo en 3 minutos
                                    ***/

                                    foreach ($explode as $w) // palabras ingresadas en arreglo
                                    {
                                        $act = false;
                                        foreach ($end as $f) // palabras encontradas
                                        {
                                            foreach($f as $wo) // multiples palabras en contexto
                                            {
                                                if((strtolower($wo) <=> strtolower($w) ) == 0 )
                                                {
                                                    $act = true ;
                                                    $find[] = $wo;
                                                }
                                            }
                                        }
                                         if(!$act)
                                         {
                                             $not_find[] = $w;
                                         }
                                    }

                                    $data[] = (object)[
                                        "redirect"   => $redirect,
                                        "find"       => $find,
                                        "notfind"    => $not_find
                                    ];


                                }
                            }



                        }
                    }

                }


                $counter++;

            }

                $this->session->set_flashdata('looking',$data);
                redirect("!/get-looking" );

                break;
            case "back":
                    /**
                     * El segmento para bvackend todavia no esta sustentado o formado
                     * en un futuro se puede programar un GET LOOKING PARA BACK-END
                     * POR EL MOMENTO se ha descontinuado
                     ***/
                    return false;
                break;
        }






        return true ;

    }
}
