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
                    "enabled"       => false
                ]);
                break;
            case "json":
                return $this->load->view($this->config->item("view_errors")['404_'], [
                    "enabled"       => true
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
                    ->GetNav((object) ["privs" => true , "json" => ($type == "json" ? true : false) , "type" => "sidebar" ])
                    ->get_siderbar_result();

    }
    
    public function Menu ($type = "object"){
        
        $type = $_GET['type'] ?? "object";

        $this->load->library("navbar");
        return $this->navbar
            ->GetNav((object) ["privs" => true , "json" => ($type == "json" ? true : false) , "type" => "sidebar" ])
            ->get_menu_result();
        
    }
}
