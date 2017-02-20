<?php

/**
 * Created by PhpStorm.
 * User: Developer 01
 * Date: 26/09/2016
 * Time: 10:48 AM
 */
class User_profile extends  CI_Model implements CoreInterface
{



    public function __construct()
    {
        parent::__construct();
        $this->load->database();
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

        $table = $this->db->dbprefix("user");
        $query = "SELECT id , username , data , privileges FROM $table ORDER BY id";

        $result         = $this->db->query($query)->result();
        $users          = NULL;
        $datauser       = NULL;
        $deptos         = NULL;
        $privs          = NULL;

        foreach ($result as $value)
        {
            $privs = json_decode($value->privileges);
            if($privs->parent != 1){
                $users[] = $value;
            }
            else if($this->user->get()->id() == $value->id)
            {
                $value->username = "Tú";
                $users[] = $value;
            }

        }

        $id = $_GET['id'] ?? NULL;



        if(!is_null($id))
        {

            $rols       = $this->db->dbprefix("rols");
            $query      = "SELECT * FROM $table WHERE id LIKE ?";
            $datauser   = $this->db->query($query , [$id])->result()[0];
            $urols      = json_decode($datauser->privileges);

            $query      = "SELECT * FROM $rols WHERE id LIKE ?";
            $privs      = $this->db->query($query, [$urols->parent])->result()[0] ?? NULL;

            $datauser->privileges = $privs;

            $this->load->library("encryption");

            $this->encryption->initialize([
                'cipher'       => 'aes-256',
                'mode'         => 'ctr',
            ]);
            

            $datauser->password = $this->encryption->decrypt($datauser->password);

            $this->load->model("profile/profile_functions");

            $privs          = $this->profile_functions->get_rols();
        }

        return $this->load->view("system/profile/user_profile" ,
            [
                "users"         => $users ,
                "datauser"      => $datauser ,
                "rols"          => $privs
            ], TRUE);
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
                 "content/assets/dashboard/css/profile.css",
                 "content/assets/dashboard/css/faq.css",
                 "content/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css",
                 "content/assets/global/plugins/bootstrap-toastr/toastr.min.css",
                 'content/system/core/css/global/select2/select2-bootstrap.min.css',
                'content/system/core/css/global/select2/select2.min.css',
                'content/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css',
                'content/assets/global/plugins/bootstrap-toastr/toastr.min.css'
             ] , "url")
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
     *
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
            site_url() . 'content/system/core/js/global/select2/select2.full.min.js',
            array("type" => "text/javascript" , "location" => "header" , "script" => site_url() . "content/assets/dashboard/js/user_profile_render.js" ),
            site_url() . 'content/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js',
            site_url() . 'content/assets/global/plugins/bootstrap-toastr/toastr.min.js'
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
        return "Perfil Usuarios";
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
        return array("admin");
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

    public function save_actions()
    {


        if(!isset($_POST['data'])) return json_encode([
            "error" => true,
            "msj"   => "Error al momento de enviar la informacion"
        ]);


        $this->load->model("profile/profile_functions");
        $success = $this->profile_functions->update_user($_POST['data'] , $_POST['i']);
        

        return json_encode([
            "error" => $success,
            "msj"   => $success == true ? "Estado cambiado con exito" : "Error Refresque la pagina e intente de nuevo"
        ]);
    }

    public function save_state()
    {
        if(!isset($_POST['state'])) return json_encode([
            "error" => true,
            "msj"   => "Error al momento de enviar la informacion"
        ]);

        $this->load->model("profile/profile_functions");
        $success = $this->profile_functions->update_state($_POST['state'] , $_POST['i']);

        return json_encode([
            "error" => $success,
            "msj"   => $success == true ? "Estado cambiado con exito" : "Error Refresque la pagina e intente de nuevo"
        ]);
    }

}