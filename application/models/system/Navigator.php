<?php

defined("NAV_NAMESPACE")    or   define("NAV_NAMESPACE" , "namespace");
defined("NAV_SIDEBAR")      or   define("NAV_SIDEBAR" , "sidebar");
defined("NAV_SECTION")      or   define("NAV_SECTION" , "section");
defined("NAV_SUBMENU")      or   define("NAV_SUBMENU" , "sub_menu");

/**
 * @author Rolando Arriaza
 * @name User
 * @access model
 * @version 1.9.3
 * @date 23-nov-2016
 * @see http://
 * @todo  model que controlo el MVC del sistema navigator
 *
 *
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


class Navigator extends CI_Model implements CoreInterface
{


    private $querys = [
        "consult"       => "SELECT * FROM [table] "
    ];
    
    private $table_nav      = '';


    private $nav_order = [
        "namespace" => [],
        "section"   => [],
        "sidebar"   => [],
        "sub_menu"  => []
    ];


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->querys       = (object) $this->querys;
        $this->table_nav    = $this->db->dbprefix("nav");
    }


    public function get_navs( $separate = true )
    {

        $this->querys->consult = str_replace("[table]" , $this->table_nav , $this->querys->consult);
        $result = $this->db->query($this->querys->consult)->result();

        if(!$separate) return $result;

        $this->nav_order = [
            "namespace" => [],
            "section"   => [],
            "sidebar"   => [],
            "sub_menu"  => []
        ];


        foreach($result as $r)
        {
            $this->nav_order[$r->type][] = $r ;
        }

        return $this->nav_order;

    }



    /**
     * @name create_operator
     * @todo crear un caso de operador , posiblemente la funcion mas importante en el
     *       hecho de desarrollo parametrico
     *
     * @author Rolando Arriaza
     * @version 1.0.0
     * @since 1.0.0
     * @param array $params , serie de parametros que se necesitan
     * @param int $id_user_operator el id del operador , opcional en dado caso no exista se tomara el id usuario actual
     * @return stdclass key_returned  if only id_operator dont exist  else count
     *
     * @modify:
     *              ID                AUTHOR                  DESCRIPTION                 DATE
     *              0               ROLANDO ARRIAZA         CREAR FUNCION               25-11-16
     *
     * @description:
     *
     *
     *
     ***/

    public function set_new_nav(
        $type ,
        $name ,
        $location ,
        $route ,
        $objects)
    {

    }


    public function tree_navs()
    {

        $navs   = $this->get_navs();
        $nodes  = [];



        $i = 0;
        foreach ($navs['namespace'] as $namespace )
        {
            $nodes[$i] = new stdClass();

            $nodes[$i]->id          = $namespace->id;
            $nodes[$i]->name        = json_decode($namespace->name) ?? $namespace->name;
            $nodes[$i]->objects     = $namespace->objects ;
            $nodes[$i]->active      = $namespace->active;
            $nodes[$i]->privs       = $namespace->privs;
            $nodes[$i]->token       = $namespace->token;
            $nodes[$i]->components  = $namespace->components;


            $section_ = [];

            foreach ($navs['section'] as $sections)
            {

                if($sections->parent == $namespace->id )
                {

                    $sidebar_section = $this->compare_sidebar($navs['sidebar'] , $sections->id);
                    $section_[] = (object)[
                        "id"                => $sections->id,
                        "name"              => $sections->name,
                        "objects"           => $sections->objects  ,
                        "active"            => $sections->active,
                        "privs"             => $sections->privs,
                        "token"             => $sections->token,
                        "components"        => $sections->components,
                        "origins"           => $sections->origins,
                        "sidebars"          => $sidebar_section,
                        "parent"            => $sections->parent 
                    ];

                }

            }


            $nodes[$i]->sections = $section_;
            $nodes[$i]->sidebars = $this->compare_sidebar($navs['sidebar'] , $namespace->id);
            $i++;
        }

        return $nodes;
    }

    private function compare_sidebar($sidebars , $parent)
    {
        $node_sidebar = array();
        foreach ($sidebars as $sidebar)
        {
            if($parent == $sidebar->parent)
            {
                $node_sidebar[] = (object)[
                    "id"                => $sidebar->id,
                    "name"              => $sidebar->name ,
                    "objects"           => $sidebar->objects,
                    "active"            => $sidebar->active,
                    "privs"             => $sidebar->privs,
                    "token"             => $sidebar->token,
                    "components"        => $sidebar->components,
                    "origins"           => $sidebar->origins,
                    "location"          => $sidebar->location,
                    "route"             => $sidebar->route,
                    "parent"            => $sidebar->parent
                ];
            }
        }

        return $node_sidebar;
    }

    /**
     * @todo inicia todos los componentes necesarios
     *       esto pueden ser librerias , helpers y las vistas
     * @return null no debe de retornar un valor ya que no se tomara en cuenta
     *
     * @example  to load view
     *
     *          return $this->load->view('view file' , $params , TRUE);
     *
     *          OR
     *
     *          return $this->load->view('view file' , '' , TRUE);
     *
     * Don´t forget the return  and the boolean TRUE
     *
     */
    public function _render($params = NULL)
    {

        // TODO: Implement _render() method.


        $this->load->library("privileges" , null , "privs");
      

        return $this->load->view('system/navigator/show' , [
            "navs"       => $this->tree_navs(),
            "lang"       => $this->user->get()->user_lang(),
            "privs"      => $this->privs->get_all_rols()
        ] , TRUE);
        
    }

    /**
     * @todo establece todas las dependencias css dentro del header
     * @example
     *
     *  <code>
     *
     *          format 1 :
     *
     *              return array(
     * 'http://hello.css',
     *                  'http://hello2.css'
     *              );
     *
     *          format 2 :
     *
     *              return array(
     * 'http://hello.css',
     *                  '<style>p { color: red; }</style>',
     *                  'http://hello2.css'
     *              );
     *
     *          format 3 :mixed array
     *
     *          return array(
     * 'http://hello.css',
     *                  '<style>p { color: red; }</style>',
     *                  'http://hello2.css',
     *                  array('http://hello3.css','http://hello4.css'),
     *                  array(
     * array('http://hello3.css','http://hello4.css'),
     *                          array(
     *                                 '<style>p { color: red; }</style>',
     *                                  array()
     *                          )
     *                  )
     *          );
     *
     *   Ok , is AWESOME write code into array mixed ! CODE IS FUN ¡
     *
     * </code>
     *
     * @return array , devuelve un arreglo con los css
     *
     */
    public function _css()
    {
        // TODO: Implement _css() method.

        return [
            print_css([
                'content/assets/global/plugins/jstree/dist/themes/default/style.min.css',
                "select2",
                "select2-bootstrap",
                "content/system/core/apps/navigator/styles.css"
            ] , 'url'),
            
        ];
    }

    /**
     * @todo establece todas las dependencias js dentro del footer
     *
     * como un solo ejemplo tenemos la siguiente devolucion
     *
     *  return array(
     * "<script>console.log('hola babyes');</script>",
     * array("type" => "text/javascript" , "location" => "header" , "script" => "<script>alert('hello');</script>"),
     * "http://hola.js",
     * [
     * "http://hola2.js",
     * "http://hola3.js"
     * ]
     *
     *
     *     <code>
     *             como parametros especificos dentro de un arreglo tenemos :
     *
     *         array("type" => "text/javascript" , "location" => "header" , "script" => "<script>alert('hello');</script>")
     *
     *         type        = tipo de documento de javascript , puede ser babel
     *         location    = en donde se colocara el script en el "header" o "footer"
     *         script      = lo que uno quiera puede ser url o script puro.
     *
     *     </code>
     *
     *
     * @return array , devuelve un arreglo con las direcciones de los js
     *
     */
    public function _javascript()
    {
        return [
            
            array(
                "type"          => "text/javascript" ,
                "location"      => "header" ,
                "script"        => site_url() . 'content/assets/global/plugins/jstree/dist/jstree.min.js',
                "systemjs"      => false
            ) ,//script exclusivo de navigator
            
            array(
                "type"          => "text/javascript" ,
                "location"      => "header" ,
                "script"        => site_url() . 'content/system/core/apps/navigator/loaders.js'
            ) ,//script exclusivo de navigator
            
            array(
                "type"          => "text/babel" ,
                "location"      => "header" ,
                "script"        => site_url() . 'content/system/core/js/garrobo/nav_render.js'
            ) ,
            
            array(
                "type"          => "text/javascript",
                "location"      => "header",
                "script"        => print_javascript("select2", "url"),
                "systemjs"      => false 
            )
        ];
    }

    /**
     *
     * @deprecated 1.5
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
        return "Navigator | V1.0.0";
    }

    /**
     * @todo funcion que requiere el nivel de seguridad de acuerdo a los roles
     *
     * <code>
     *
     *  ok privileges funciona para darle un nivel mas de seguridad y que no utilicen
     *  alguna back-door
     *
     *  puedes agregar privilegios estaticos o con algun algoritmo de seguridad que retorne
     *  el rol que se desea analizar o computar
     *
     *  esta funcion retorna valores mixtos
     *
     *  puede retornar un string de esta forma
     *
     *      return '1,2,3,4'
     *      return 'admin,user'
     *
     *      acepta estos tokens
     *
     *          [, | & % &]
     *
     *      entonces return '1%2%3' es aceptable
     *
     *      tambien puedes devolver un arreglo no asociado
     *
     *          return array('admin' , 'user' );
     *          return array(1,2,3);
     *
     * </code>
     *
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



}