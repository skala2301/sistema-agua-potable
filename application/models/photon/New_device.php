<?php


class New_device extends CI_Model implements CoreInterface
{


    protected  $table               = "device" ;


    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model("photon/tools_devices");
        $this->table =  $this->db->dbprefix($this->table);
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

        $particle_url = $this->tools_devices->get_particle_url();

        return $this->load->view("photon/new_device" , [
            "particle_url"  => $particle_url
        ] , TRUE );

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

        return print_css([
            "content/assets/global/plugins/datatables/datatables.min.css",
            "content/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css"
        ]);
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
        // TODO: Implement _javascript() method.

        return [

            array(
                "type"          => "text/javascript" ,
                "location"      => "header" ,
                "script"        => site_url() . 'content/assets/apps/photon/photon.js',
                "systemjs"      => false
            ) ,//script exclusivo de navigator

            array(
                "type"          => "text/babel" ,
                "location"      => "header" ,
                "script"        => site_url() . 'content/assets/apps/photon/create_photon.js'
            ) ,//cargamos el render
            array(
                "type"          => "text/javascript" ,
                "location"      => "footer" ,
                "script"        => site_url() . 'content/assets/apps/projects/project_loader.js',
                "systemjs"      => false
            ),
            array(
                "type"          => "text/javascript" ,
                "location"      => "footer" ,
                "script"        => site_url() . 'content/assets/pages/scripts/table-datatables-scroller.min.js',
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

    public function create_photon(){


        $data       = [];
        $serialize  =    $this->input->post("data");
        $pkg        =    $this->input->post("pkg");
        $device     =    $this->input->post("device");

        if(is_null($serialize) || empty($serialize))
            return json_encode([
                "status"        => false,
                "msj"           => "Error al momento de procesar la data",
                "data"          => $serialize
            ]);


        parse_str($serialize , $data);

        $this->load->model("projects/tools_project" , "projects_");
        $this->load->model("photon/tools_devices" , "tdevices_");

        $project_id    = $data['photon-project'];
        $project_privs = $this->projects_->get_privs_project($project_id);
        $package       = $this->tdevices_->set_package($pkg , $project_id , $project_privs);


        if(!$package->status ){
            return json_encode([
                "status"        => false,
                "msj"           => "El paquete no se pudo crear, el proceso se ha terminado",
                "data"          => null
            ]);
        }


        $device     = json_decode($device);
        $date       = new DateTime("now");
        $insert_    = [];


        foreach ( $device as $dev) {
            $insert_[] = [
              "name"                    =>   $dev->name,
              "global_var"              =>   "" ,
              "token_id"                =>   $data['photon-token'] ,
              "particle_id"             =>   $dev->id,
              "create_date"             =>   $date->format("y-m-d h:m:s"),
              "id_package"              =>   $package->id
            ];
        }

       /* $this->db->insert($this->table , [
             "name"             => $data['photon-name'] ?? "",
            "global_var"        => $data['photon-global'] ?? "",
            "token"             => $data['photon-token'] ?? "",
            "pid"               => $data['photon-id'] ?? "",
            "create_date"       => $date->format("y-m-d h:m:s"),
            "id_package"        => $package->id
        ]);*/

        $this->db->insert_batch($this->table , $insert_);


        if($this->db->affected_rows() == 0){

            $this->tdevices_->delete_package($package->id);
            return json_encode([
                "status"        => false,
                "msj"           => "la creacion de este dispositivo produjo un error",
                "data"          => null
            ]);
        }

        return json_encode([
            "status"        => true,
            "msj"           => "Dispositivo creado con exito !!",
            "data"          => null
        ]);


    }

}