<?php

/**
 * @author Rolando Arriaza 
 * @name UserType 
 * @access public
 * @version 1.0
 * @date 16-nov-2016
 * @see http:// 
 * @todo esta clase maneja todo lo relacionado con el tipo de usuario
 *       para iniciar esta clase los objetos devueltos de la base de 
 *       datos se debe tener en cuenta la funcion _get() que devuelve 
 *       el puntero en si de la clase 
 * 
 *       ejemplo:
 * 
 *              this->usertype->_get()-Show($utype);
 * 
 *                      o tambien 
 * 
 *              this->usertype->_get();
 *              this->usertype->Show($utype);
 * 
 * 
 * ---------------------------------------------------------------------------
 *                           ULTIMAS MODIFICACIONES
 *          
 *  Nombre                         Fecha              Comentario 
 * <rolignu>                    <16-nov-2016>        <creacion de la clase>
 *  
 * 
 */

class UserType extends SystemError  {
    
    
    //variables protejidas 
    protected $ins = null;
    
    protected $err = null;
    
    protected $querys = [
        
        "data"      => "SELECT * FROM [TABLE] "
        
    ];
    
    //variables privadas
    private $tb_user_type = null;
    
    private $ut_result = null;
    
    
    //constructor de la clase 
    public function __construct() {
        $this->ins = &get_instance();
        $this->ins->load->database();
        
        $this->tb_user_type = $this->ins
                                    ->db
                                    ->dbprefix("user_type");
    }
    
    
    /**
     * @author Rolando Arriaza <rolignu>
     * @todo funcion de inicio a la base de datos 
     * @return $this , retorna el puntero 
     * @last_modify_date 17-nov-2016
     * @last_modify_dev  rolignu
     * ***/
    public function _get()
    {
        $this->ut_result = $this->ins
                ->db
                ->query(str_replace("[TABLE]", 
                        $this->tb_user_type, 
                        $this->querys['data']))
                ->result();
        
        return $this;
    }
    
    public function Compare($user_type)
    {
        
    }
    
    
     /**
     * @author Rolando Arriaza <rolignu>
     * @todo funcion que devuelve el resultado de type y label 
      *      ideal para hacer un <select></select>
     * @return $array/object , retorna un arreglo de objetos
     * @last_modify_date 17-nov-2016
     * @last_modify_dev  rolignu
     * ***/
    public function ShowArray( )
    {
        $std = [];
        foreach($this->ut_result as $result)
        {
            $d = new stdClass();
            $d->type        = $result->type ;
            $d->label       = $result->label;
            $std[] = $d;
        }
        
        return $std;
    }
    
    
    /**
     * @author Rolando Arriaza <rolignu>
     * @todo funcion que devuelve el type y label segun el usuario
     *      ideal para hacer un <select></select> o <input> 
     * @params $utype , typos de usuarios segun base de datos 
     * @return object stdclass[ type , label ]
     * @last_modify_date 17-nov-2016
     * @last_modify_dev  rolignu
     * ***/
     public function Show($utype)  
    {
        foreach($this->ut_result as $result)
        {
            if($utype == $result->type)
            {
                return (object) [
                    "type"  => $result->type,
                    "label" => $result->label 
                ]; 
            }
        }
        
        return (object) [];
    }
    
    
    /**
     * @author Rolando Arriaza <rolignu>
     * @todo devuelve el properties segun el tipo de usuario 
     * @params $utype , typos de usuarios segun base de datos 
     * @return int [ properties = 0 , todo los datos de acceso ]
     * @last_modify_date 17-nov-2016
     * @last_modify_dev  rolignu
     * ***/
    
    public function get_prop($utype)
    {
        foreach($this->ut_result as $result)
        {
            if($result->type  == $utype )
            {
                return $result->properties;
            }
        }
        
        return NULL; 
    }
    
    
    
    
}
