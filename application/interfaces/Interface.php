<?php

/**
 * @version 1.5
 * @author Rolando Arriaza
****/


interface CoreInterface {
    
    
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
    public function _render($params = NULL);
  
 
    /**
     * @todo establece todas las dependencias css dentro del header
     * @example
     *
     *  <code>
     *
     *          format 1 :
     *
     *              return array(
                        'http://hello.css',
     *                  'http://hello2.css'
     *              );
     *
     *          format 2 :
     *
     *              return array(
                        'http://hello.css',
     *                  '<style>p { color: red; }</style>',
     *                  'http://hello2.css'
     *              );
     *
     *          format 3 :mixed array
     *
     *          return array(
                        'http://hello.css',
     *                  '<style>p { color: red; }</style>',
     *                  'http://hello2.css',
     *                  array('http://hello3.css','http://hello4.css'),
     *                  array(
                                array('http://hello3.css','http://hello4.css'),
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
    public function _css();
    
     /**
     * @todo establece todas las dependencias js dentro del footer
      *
      * como un solo ejemplo tenemos la siguiente devolucion
      *
      *  return array(
                "<script>console.log('hola babyes');</script>",
                array("type" => "text/javascript" , "location" => "header" , "script" => "<script>alert('hello');</script>"),
                "http://hola.js",
                [
                    "http://hola2.js",
                    "http://hola3.js"
                ]
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
    public function _javascript();
    
     /**
      *
      *@deprecated 1.5
     * @todo establece funciones javascript dentro de DOM init o document.ready
     * @return array , devuelve un array donde iran las funciones 
     * @example  arra("funcion1();" , "var func = function(){}" , ...);
     *                 
     */
    public function _actionScript();
    
     /**
     * @todo establece el titulo dentro del header 
     * @return string , solo devuelve una cadena ... 
     *                 
     */
    public function _title();
    
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
    public function _privileges();
    
  
    /**
     * aca se carga todo lo que iniciara eventualmente en el dashboard
     * por medio de un proceso en segundo plano js
     */
    public function _actionScriptDashboard();
    
    
    /**
     * actions es una funcion interfaz en cual verifica todas la acciones del sistema
     */
    public function _actions();
   
  
}
