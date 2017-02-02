<?php

defined("NAMESPACES")        or define("NAMESPACES", "namespace");
defined("SECTION")          or define("SECTION", "section");
defined("NAVIGATION")       or define("NAVIGATION", "navigation");
defined("SIDEBAR")          or define("SIDEBAR", "sidebar");


/**
 * @author Rolando Arriaza <rolignu90@gmail.com>
 * @version 1.2.1
 * @todo navbar
 *
 *         use case :
 *
 *              create a database
 *
 *              CREATE TABLE `ga_nav` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`type` VARCHAR(50) NOT NULL,
`name` VARCHAR(50) NULL DEFAULT NULL,
`location` VARCHAR(50) NULL DEFAULT NULL,
`route` VARCHAR(50) NULL DEFAULT NULL,
`objects` TEXT NULL,
`components` TEXT NULL,
`parent` VARCHAR(255) NULL DEFAULT NULL,
`origins` VARCHAR(255) NULL DEFAULT NULL,
`active` INT(11) NULL DEFAULT '0',
`privs` VARCHAR(255) NULL DEFAULT '0',
`token` VARCHAR(100) NULL DEFAULT NULL,
PRIMARY KEY (`id`)
)
COMMENT='navbar version 1.0 '
COLLATE='latin1_swedish_ci'
ENGINE=MyISAM
AUTO_INCREMENT=1;
 *
 *
 *              type = string of [ namespace , sidebar , section , sub_menu ]
 *              name = string/json (name of data show ) , (locale json) [ {"es": "Ejemplo español" , "en" : "English example" } ]
 *              location = MVA (dir=model)
 *              route = simple route MVA (dir=model) , route = my_route
 *              object =
 *
 *                      to namespace, sidebar , section :  {"icon" : "","redirect": "","target" : ""}
 *                      to sub_menu :  {"icon" : "icon-key","redirect": "","target" : "","place" : "1"}
 *
 *                                  where place like oredr to appear
 *                                  and target is a __blank or someting else
 *                                  redirec if exist a another direction
 *
 *              components = json { "a" : "hello" , "b" : "its me"}
 *
 *              parent : who is the parent , only one child in parent , not multiple childs : example : 5
 *
 *              origins : system , plugin  or another origin
 *
 *              privs : privilege based an id role : 1 or 1,2,3
 *
 *              token : token if necessary
 *
 *
 ***/

class NavBar {


    protected  $instance ;

    protected  $navbar      = NULL;

    private    $table       = NULL;

    private    $dashboard   = NULL;

    var       $pointer      = NULL;

    var       $config       = '';

    var       $last_query   = "";

    private $querys = [

        "navbar"                => "SELECT * FROM [table]",
        "nav_privs"             => "SELECT * FROM [table] WHERE privs LIKE '%#1%'",
        "nav_find"              => "SELECT * FROM [table] WHERE privs IN (#1,0)",
        "nav_find_exp"          => "SELECT * FROM [table] WHERE [condition]",
        "routes"                => "SELECT [table].location FROM [table] WHERE route LIKE ? ",
        "operator"              => "SELECT operator FROM [table] WHERE id LIKE ?"
    ];

    public function __construct() {
        $this->instance                     = &get_instance();
        $this->instance
            ->load->database();

        $this->table                        = $this->instance->db->dbprefix("nav");

        $this->instance->load
                            ->library("querybuild");

        $this->instance->load->helper("tools");

        $this->dashboard = $this->instance->config->item("backend") . "/";


    }

    public function __destruct() {
        unset($this->instance);
        unset($this->navbar);
    }

    public function edit_nav_byId($id , $data )
    {
        $this->instance->db->where('id', $id);
        return  $this->instance->db->update($this->table , $data );
    }

    public function update_operator($id , $operator)
    {
        $this->instance->db->where('id', $id);
        $result = $this->instance->db->update($this->table , ["operator" => $operator] );
        return $result == true  ?  $this->instance->db->affected_rows() : 0;
    }

    public function get_operator($id)
    {
        $query = str_replace("[table]" , $this->table , $this->querys['operator']);
        return $this->instance->db->query($query , [$id])->result()[0]->operator ?? NULL ;
    }

    public function delete_nav_byId($id)
    {
        $result = $this->instance->db->delete($this->table , [ "id" => $id ]);
        return $result == true  ?  $this->instance->db->affected_rows() : 0;
    }

    public function get_NavLocation($route)
    {
        $result = $this->instance
                ->db
                ->query(str_replace("[table]", $this->table , $this->querys['routes']) , [$route])
                ->result()[0]
                ->location ?? null;

        return $result;
    }

    /**
     * @version 2.1.0
     * @author Rolando Arriaza <rolignu90@gamail.com>
     * @param object $config configuracion del nav
     *        esto permite elejir que valor de salida o si acepta roles
     *        entre otras cosas
     *
     *        el ejemplo que se puede dar para el llamado de la configuracion
     *        seria la siguiente
     *
     *      GetNav((object) ["privs" => true , "json" => true , "type" => "sidebar" ])
     *
     *              privs = true | false
     *
     *                      Si el menu no quiere que filtrs privilegios y sea para todo el mundo
     *
     *             json = true | false
     *
     *                      salida en json o salida en object class
     *
     *             type = sidebar | navigation
     *
     *                  se compone de dos formatos
     *                  todos los componenetes que deben de ir a lado derecho
     *
     *                  y todos los componentes que deben de ir a lado izquierdo
     *
     * **/
    public function GetNav( $config = null )
    {


        $objects             = new stdClass();
        $objects->table      = $this->table;
        $this->config        = $config;


        if($config->privs == true ) {


            /**
             * verificamos si hay privilegios
             */

            $this->instance->load->library("user");

            $parent =   $this->instance->user->privileges(false)->get_parent();
            $child =    $this->instance->user->get_childs();


            $objects->query = $this->querys['nav_find_exp'];

            $objects->params['parent'] = $parent;

            $objects->params['child'] = explode("," , $child);


            $query = str_replace("[table]" , $objects->table , $objects->query);
            $cond  = ' privs ';

            if($objects->params['parent'] !=null){
                $cond .= " LIKE '%" . $objects->params['parent'] . "%'";
            }

            if(count($objects->params['child']) >= 1)
            {
                foreach($objects->params['child'] as $children)
                {
                    if($children != null || !empty($children))
                            $cond .= " OR privs LIKE '%". $children . "%' ";
                }
            }

            if(strpos($cond , "LIKE"))
            {
                $cond .= " OR privs LIKE '%0%'";
            }
            else
            {
                $cond .= " LIKE '%0%'";
            }


            $cond.= " ORDER BY [table].`type` ASC ";
            $cond = str_replace("[table]" , $objects->table , $cond);

            $query = str_replace("[condition]" , $cond , $query );




        }else{
            //comming soon
        }


        $this->pointer = $this->instance
            ->db
            ->query($query)
            ->result();

        return $this;

    }


    /**
     * return a sidebar
     ***/
    public function get_siderbar_result()
    {

        

        $filter =  $this->filter($this->pointer);


        switch ($this->config->json)
        {
            case TRUE;
                return json_encode($filter);
            case FALSE:
                return $filter;
        }

    }


    /**
     * return a menu of system
     **/
    public function get_menu_result()
    {

        $menu = $this->menu_filter($this->pointer);
        switch ($this->config->json)
        {
            case TRUE;
                return json_encode($menu);
            case FALSE:
                return $menu;
        }
    }


    /**
     * only a menu filter data
     **/
    private function menu_filter($pointer)
    {
        $menu = [];
        $this->instance->load->helper("cookie");
        foreach ($pointer as $data)
        {
            if($data->type == "sub_menu")
            {
                $format            = new stdClass();
                $format->type      = $data->type;

                $mname             = json_decode($data->name);
                if(is_null($mname))
                    $format->name      = $data->name;
                else{
                    $lang          = backend_session_lang() ?? "en";
                    $format->name  = $mname->$lang;
                }

                $format->location  = !is_null($data->route) ? $data->route : $data->location;
                $format->dashboard = $this->instance->config->item("backend");
                $format->id        = $data->id;

                $objects           = json_decode($data->objects);
                $format->icon      = $objects->icon ?? null;
                $format->place     = $objects->place ?? rand(-1000,-1);
                $format->divider   = $objects->divider ?? false;
                $menu[] = $format;
            }
        }

        for($i = 0 ; $i < count($menu) ; $i++)
        {
            if( ($i +1) < count($menu))
            {
                if($menu[$i]->place  > $menu[$i+1]->place)
                {
                    $d = $menu[$i];
                    $menu[$i] = $menu[$i+1];
                    $menu[$i+1] = $d;
                }
            }
        }

        return $menu;


    }


    /**
     * @todo Algoritmo recursivo de filtro
     * @version 1.1.0
     * @author Rolando Arriaza <rolignu90>
     * @param  object | stdclass $objects clase o objeto donde contiene todo el menu de navegacion
     * @param  array   $returns parametro de devolucion de objeto recursivo
     * @param  int $counter contador de index del objeto valor inicial = 0
     * @return object | stdclass devuelve una clase filtrada
     ****/
    private function filter ($objects  , $returns = NULL , $counter = 0)
    {

        if($returns == NULL ){
            $returns = [];
        }


        if($objects[$counter]->active == 1) {


            $data_objects = json_decode($objects[$counter]->objects);

            switch ($objects[$counter]->type) {
                case NAMESPACES:

                    if (!array_key_exists($objects[$counter]->id, $returns)) {
                        $returns[$objects[$counter]->id] = new stdClass();


                        $mname             = json_decode($objects[$counter]->name);
                        if(is_null($mname))
                            $returns[$objects[$counter]->id]->name      = $objects[$counter]->name;
                        else{
                            $lang                                   = backend_session_lang() ?? "en";
                            $returns[$objects[$counter]->id]->name  = $mname->$lang;
                        }

                        $returns[$objects[$counter]->id]->type          = $objects[$counter]->type;
                        $returns[$objects[$counter]->id]->origin        = $objects[$counter]->origins;
                        $returns[$objects[$counter]->id]->objects       = $data_objects;
                        $returns[$objects[$counter]->id]->section       = [];
                        $returns[$objects[$counter]->id]->sidebar       = [];
                    }
                    break;
                case SIDEBAR :

                    $parent = $objects[$counter]->parent;
                    foreach ($returns as $k=>$data) {

                        if (array_key_exists($parent, $data->section)) {
                            $data->section[$parent]->sidebar[$objects[$counter]->id] = new stdClass();


                            $mname             = json_decode($objects[$counter]->name);
                            if(is_null($mname))

                                $data->section[$parent]->sidebar[$objects[$counter]->id]->name     = $objects[$counter]->name;
                            else{
                                $lang                                   = backend_session_lang() ?? "en";
                                $data->section[$parent]->sidebar[$objects[$counter]->id]->name  = $mname->$lang;
                            }

                            //$data->section[$parent]->sidebar[$objects[$counter]->id]->name = $objects[$counter]->name ;
                            $data->section[$parent]->sidebar[$objects[$counter]->id]->location = $objects[$counter]->location;
                            $data->section[$parent]->sidebar[$objects[$counter]->id]->route = $objects[$counter]->route;
                            $data->section[$parent]->sidebar[$objects[$counter]->id]->origin = $objects[$counter]->origins;
                            $data->section[$parent]->sidebar[$objects[$counter]->id]->dashboard = $this->dashboard;
                            $data->section[$parent]->sidebar[$objects[$counter]->id]->objects = $data_objects;

                            break;
                        }
                        else if(($parent <=> $k ) == 0 )
                        {


                            $data->sidebar[$objects[$counter]->id] = new stdClass();

                            $mname             = json_decode($objects[$counter]->name);
                            if(is_null($mname))
                                $data->sidebar[$objects[$counter]->id]->name     = $objects[$counter]->name;
                            else{
                                $lang                                   = backend_session_lang() ?? "en";
                                $data->sidebar[$objects[$counter]->id]->name  = $mname->$lang;
                            }

                            // $data->sidebar[$objects[$counter]->id]->name = $objects[$counter]->name;
                            $data->sidebar[$objects[$counter]->id]->location = $objects[$counter]->location;
                            $data->sidebar[$objects[$counter]->id]->route = $objects[$counter]->route;
                            $data->sidebar[$objects[$counter]->id]->origin = $objects[$counter]->origins;
                            $data->sidebar[$objects[$counter]->id]->dashboard = $this->dashboard;
                            $data->sidebar[$objects[$counter]->id]->objects = $data_objects;

                            break;
                        }
                        else
                        {
                            foreach($data->section as $skey=>$section)
                            {
                                // echo "<pre>" , print_r($section) , "</pre>";
                                if(isset($section->section))
                                {
                                    if(array_key_exists($parent , $section->section))
                                    {
                                        $section->section[$parent]->sidebar[$objects[$counter]->id]                 = new stdClass();

                                        $data->sidebar[$objects[$counter]->id] = new stdClass();


                                        $mname             = json_decode($objects[$counter]->name);
                                        if(is_null($mname))
                                            $section->section[$parent]->sidebar[$objects[$counter]->id]->name      = $objects[$counter]->name;
                                        else{
                                            $lang                                   = backend_session_lang() ?? "en";
                                            $section->section[$parent]->sidebar[$objects[$counter]->id]->name   = $mname->$lang;
                                        }

                                        //$section->section[$parent]->sidebar[$objects[$counter]->id]->name           = $objects[$counter]->name;
                                        $section->section[$parent]->sidebar[$objects[$counter]->id]->location       = $objects[$counter]->location;
                                        $section->section[$parent]->sidebar[$objects[$counter]->id]->route          = $objects[$counter]->route;
                                        $section->section[$parent]->sidebar[$objects[$counter]->id]->origin         = $objects[$counter]->origins;
                                        $section->section[$parent]->sidebar[$objects[$counter]->id]->objects        = $data_objects;
                                        $section->section[$parent]->sidebar[$objects[$counter]->id]->dashboard      =$this->dashboard;

                                        break;
                                    }
                                }


                            }
                        }


                    }
                    break;
                case SECTION:
                    $parent = $objects[$counter]->parent;


                    foreach ($returns as $key => $value) {

                        if (($key <=> $parent) == 0) {

                            $value->section[$objects[$counter]->id] = new stdClass();
                            $value->section[$objects[$counter]->id]->type           = $objects[$counter]->type;

                            $mname             = json_decode($objects[$counter]->name);
                            if(is_null($mname))
                                $value->section[$objects[$counter]->id]->name        = $objects[$counter]->name;
                            else{
                                $lang                                   = backend_session_lang() ?? "en";
                                $value->section[$objects[$counter]->id]->name     = $mname->$lang;
                            }

                            //$value->section[$objects[$counter]->id]->name           = $objects[$counter]->name;
                            $value->section[$objects[$counter]->id]->active         = $objects[$counter]->active;
                            $value->section[$objects[$counter]->id]->origin         = $objects[$counter]->origins;
                            $value->section[$objects[$counter]->id]->objects        = $data_objects;
                            $value->section[$objects[$counter]->id]->sidebar        = [];
                            $value->section[$objects[$counter]->id]->section        = [];
                            break;
                        }
                        else if(array_key_exists($parent , $value->section ))
                        {


                            $value->section[$parent]->section[$objects[$counter]->id]                 = new stdClass();
                            $value->section[$parent]->section[$objects[$counter]->id]->type           = $objects[$counter]->type;

                            $mname             = json_decode($objects[$counter]->name);
                            if(is_null($mname))
                                $value->section[$parent]->section[$objects[$counter]->id]->name         = $objects[$counter]->name;
                            else{
                                $lang                                   = backend_session_lang() ?? "en";
                                $value->section[$parent]->section[$objects[$counter]->id]->name      = $mname->$lang;
                            }

                            //$value->section[$parent]->section[$objects[$counter]->id]->name           = $objects[$counter]->name;
                            $value->section[$parent]->section[$objects[$counter]->id]->active         = $objects[$counter]->active;
                            $value->section[$parent]->section[$objects[$counter]->id]->origin         = $objects[$counter]->origins;
                            $value->section[$parent]->section[$objects[$counter]->id]->objects        = $data_objects;
                            $value->section[$parent]->section[$objects[$counter]->id]->sidebar        = [];
                        }

                    }
                    break;
            }
        }

        if(sizeof($objects) === ($counter+1)) return $returns;

        $counter++;
        return $this->filter($objects , $returns , $counter);

    }

}
