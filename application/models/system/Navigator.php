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

        $this->load->library("navbar");
        $this->load->library("operator");
    }



    public function get_sub_menus() : string
    {
        return json_encode($this->get_navs( true , "sub_menu"));
    }


    public function get_navs( $separate = true  , $filter = null )
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

        if(is_null($filter))
            return $this->nav_order;

        switch ($filter)
        {
            case "sub_menu":
                return $this->nav_order['sub_menu'];
            case "namespace" :
                return $this->nav_order['sub_menu'];
            case "section":
                return $this->nav_order['sub_menu'];
            case "sidebar" :
                return $this->nav_order['sub_menu'];
            default:
                return $this->nav_order;
        }
    }

    public function Save() : string {

        $values                 = array();
        $dnames                 = array();
        $convert_names          = array();
        $objects                = array();

        $serial = $this->input->post("data");
        $target = $this->input->post("target");
        $privs  = $this->input->post("privs");
        $names  = $this->input->post("names");

        switch ($target)
        {
            case NAV_NAMESPACE :
            case NAV_SECTION:
            case NAV_SIDEBAR:
            case NAV_SUBMENU:
                break;
            default:
                return json_encode([
                    "error"             => true ,
                    "message"           => "Esta categoria [$target] no existe favor verificar.",
                    "warning"           => false
                ]);
        }


        parse_str($serial , $values);
        parse_str($names , $dnames);

        $dnames = $dnames['names'];
        foreach($dnames as $vnames)
        {
            $convert_names[$vnames['lang']] =  $vnames['value'];
        }


        $objects = [
            "icon"              => $values['txt-icon'] ,
            "redirect"          => $values['txt-redirect'],
            "target"            => $values['txt-target'],
            "place"             => $values['txt-place'],
            "divider"           => $values['txt-divider'] == 1 ? 'true' : 'false'
        ];


        $operator = random_string('md5');


        $insert_data = [
            "type"            => $target,
            "name"            => json_encode($convert_names),
            "location"        => $values['txt-location'] ,
            "route"           => $values['txt-route'] ,
            "objects"         => json_encode($objects),
            "components"      => $values['txt-components'] ,
            "parent"          => $values['txt-parent-id'] ,
            "origins"         => $values['txt-origin'],
            "active"          => 1,
            "privs"           => $privs ,
            "token"           => $values['txt-token'] ,
            "operator"        => $operator
        ];



        $this->db->insert($this->table_nav , $insert_data);

        $insert_id = $this->db->insert_id() ;
        $affected  = $this->db->affected_rows();

        $query = "INSERT GA_NAV , PARAMS(" . serialize($insert_data) . ") , ID($insert_id)";


        $operator = $this->operator->create_insert_operator(
            $this->user->get()->id(),
            $query,
            $operator,
            $affected,
            $this->table_nav
        );


        unset($affected);
        unset($insert_data);
        unset($objects);
        unset($convert_names);
        unset($dnames);
        unset($values);
        unset($query);

        if($insert_id > 0  && $operator >= 1 )
        {
            return json_encode([
                "error"             => false ,
                "message"           => 'Navegador creado con exito !! (Operador pendiente de revision)',
                "warning"           => false
            ]);
        }
        else if($operator == 0 && $insert_id >= 1)
        {
            return json_encode([
                "error"             => false ,
                "message"           => 'Operador no se pudo crear para esta insercion',
                "warning"           => true
            ]);
        }
        else if($insert_id == 0 || $insert_id == null && $operator == 0)
        {
            return json_encode([
                "error"             => true  ,
                "message"           => 'No se pudo realizar la insercion.',
                "warning"           => false
            ]);
        }


        return json_encode([
            "error"             => true  ,
            "message"           => 'ejecucion con valores devueltos inesperados',
            "warning"           => true
        ]);


    }

    public function Edit()
    {
        $data_request = $this->input->post("data");
        $data_review  = [];
        $id = null;


        foreach($data_request as $request){

            switch ($request['name'])
            {
                case "id":
                    $id  = $request['data'] ?? null ;
                    break;
                case "nav_type":
                    $data_review['type'] = $request['data'] ?? null ;
                    break;
                case "privs-loaders":
                    $data_review['privs'] =  !empty($request['data']) ? implode("," , $request['data']) : 0;
                    break;
                default:
                    $data_review[$request['name']] = $request['data'] ?? null ;
                    break;
            }




        }

        if(isset($data_review['id'])) unset($data_review['id']);

        $result = $this->navbar->edit_nav_byId($id , $data_review);

        if($result >= 1)
        {
            $operator = $this->navbar->get_operator($id);

            $query = "UPDATE GA_NAV , PARAMS(" . serialize($data_review) . ") , ID($id)";

            $op_result = $this->operator
                              ->create_update_basic_operator($this->user->get()->id(),
                                  $query ,
                                  $operator ,
                                  $result ,
                                  $this->db->dbprefix("nav"));


            if($operator == NULL )
            {
                $this->navbar->update_operator($id , $op_result[0]->key_returned ?? NULL);
            }

        }

        return $result;

    }

    public function Delete($id=null )
    {
        $id = $id != null ? $id : $this->input->post("id");

        if(is_null($id)) return false;
        $result = $this->navbar->delete_nav_byId($id);

        if($result >= 1)
        {
            $operator = $this->navbar->get_operator($id);

            $query = "DELETE GA_NAV , PARAMS(" . serialize(["id" => $id ]) . ") , ID($id)";

            $op_result = $this->operator
                ->create_update_basic_operator($this->user->get()->id(),
                    $query ,
                    $operator ,
                    $result ,
                    $this->db->dbprefix("nav"));


            if($operator == NULL )
            {
                $this->navbar->update_operator($id , $op_result[0]->key_returned ?? NULL);
            }

        }


        return $result >= 1 ? 1 : 0;
    }

    public function get_navs_meta($array = false)
    {
        $this->load->library("meta");
        switch($array)
        {
            case true :
                 return $this->meta->get_meta_value("nav_data" , true );
                break;
            case false :
                return  (object) $this->meta->get("nav_data")[0] ?? NULL ;
        }

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
            $nodes[$i]->type        = $namespace->type;

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
                        "parent"            => $sections->parent ,
                        "type"              => $sections->type
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
                    "parent"            => $sidebar->parent,
                    "type"              => $sidebar->type
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
            "privs"      => $this->privs->get_all_rols(),
            "navs_meta"  => $this->get_navs_meta(true)
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
                "script"        => site_url() . 'content/system/core/apps/navigator/nav_render.js'
            ) ,//script sclusivo de navigator
            
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
        return ( "admin" );
    }



}