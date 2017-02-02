<?php

/**
 * @author Rolando Arriaza
 * @name Operator
 * @access public
 * @version 1.0.0
 * @date 23-nov-2016
 * @see http://
 * @todo Clase Operator , esta clase se encarga de crear las intancias operador usuario
 *             y se encarga de conectar los movimientos a la tabla de operator_log
 *
 *
 * Referencias : la tabla operator_log contiene un campo peculiar llamado "log"
 *
 *                  la construccion de este log es un archivo tipo json  la cual llevara lo siguiente
 *
 *              JSON :
 *
 *                      {
                            id_user_operator : ""
 *                          table : {
                                        table_name : "",
 *                                      affected_rows : "",
 *                                  },
 *                          user : {
                                        id_user_affected : "" ,
 *                                  },
 *                          affected : {
                                        date : "",
 *                                      hour : "",
 *                                      action : "",
 *                              },
 *                          status : {
                                rollback : false ,
 *                              approved  : true ,
 *                              id_user_approved : "",
 *                              active : false
 *                          }
 *                      }
 *
 *          NOTA : ESTO ES UN EJEMPLO COMO SE VE EL ARCHIVO JSON DENTRO DE LOG
 *
 * ---------------------------------------------------------------------------
 *                           ULTIMAS MODIFICACIONES
 *
 *  Nombre                         Fecha              Comentario
 * <rolignu>                    <23-nov-2016>        <Creacion de la clase>
 *
 *
 */


class Operator extends User
{

    public $operator_actions =  [
        "del" => "DELETE" ,
        "in"  => "INSERT OR CREATE" ,
        "co"  => "CONSULT" ,
        "up"  => "UPDATE" ,
        "sp"  => "STORED PROCEDURE ACTION"
    ];


    private $sp_operator_type = [
        "create"                    => "C",  //CREAR UN NUEVO LOG OPERATOR
        "select"                    => "S",  //SELECCIONAR TODO EL OPERADOR POR MEDIO DE id_operator
        "update_log"                => "UL"  //Actualizar solo el log del operador por medio del id_op_log
    ];


    /**
     *  PARA sp_operator
     *
     *      IN e_type					VARCHAR(3),
            IN i_op_type				VARCHAR(4),
            IN i_id_operator 			VARCHAR(255),
            IN i_id_user 				INT(11),
            IN i_affected_table 		VARCHAR(100),
            IN i_id_company			INT(11),
            IN i_log						TEXT ,
            IN e_id_op_log				INT(11)
     *
     *
    ***/

    protected $stored_procedures = [
         "sp_operator" => "CALL sp_operator(?,?,?,?,?,?,?,?)"
    ];


    /**
     *  esta variable tiene el formato estandar sobre el log del operador
     *  en su formato estandar esta los siguientes:
     *
     *      id_user_operator = id del usuario operador
     *      table : tabla afectada
     *              -- table name      : nombre de esta tabla
     *              -- affected_rows   : cantidad de filas afectadas
     *              -- query : query que se emitio
     *      user : usuario afectado , a que usuario
     *              --id_user_affected : el id del usuario
     *              --id_users_affected : id de usuarios afectados
     *
     *      company :
     *                -- id_company_affected : id de la compañia afectada
     *
     *      affected :
     *               -- date : fecha afectado
     *               -- hour : hora afectada
     *               -- action : accion requerida : select , insert , delete , update etc
     *
     *      status :
     *              --rollback : se ha hecho un rollback   (BOOL)
     *              -- approved : se ha aprobado            (BOOL)
     *              -- id_user_aproved: quien lo aprobo    (INT)
     *              -- active : esta vigente                (BOOL),
     *      sp :
     *             --name : nombre del procedimiento ejecutado
     *             --params : parametros ejecutados
    ***/
    protected $json_base_encode = '{
            "id_user_operator": "",
            "table": {
                    "table_name": "",
                    "affected_rows": "",
                    "query" : ""
            },
            "user": {
                    "id_user_affected": "",
                    "users_affected" : {}
            },
            "company" : {
                     "id_company_affected" : ""
            },
            "affected": {
                    "date": "",
                    "hour": "",
                    "action": ""
             },
            "status": {
                    "rollback": false,
                     "approved": true,
                      "id_user_approved": "",
                      "active": false
             },
             "sp" : {
                    "name" : "",
                    "params" : {}
             }
        }';


    private $decode_ = null;

    public function __construct()
    {
        parent::__construct();
        $this->decode_ = json_decode($this->json_base_encode);
        $this->operator_actions = (object) $this->operator_actions;
        $this->sp_operator_type = (object) $this->sp_operator_type;
    }

    public function op_actions(){return $this->operator_actions;}

    public function show_decode(){return $this->decode_;}

    public function show_encode(){return $this->json_base_encode;}

    public function sp_op_type() { return $this->sp_operator_type; }

    public function get_operator_md5()
    {
        $instance = parent::get_instance();
        $instance->load->helper("string");
        return random_string('md5');
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
             *              O ==> SE CREO LA FUNCION
             *
             *
             * @other :
             *
             *          $params : array
             *
             *                  id_operator             =>  STRING  MD5()
             *                  affected_table          =>  STRING
             *                  id_company              =>  STRING
             *                  id_operator_type        => INT
             *
             *
             *
             *                  affected_rows           => INT
             *                  query                   => STRING
             *                  id_user_affected        => INT  (one number)
             *                  users_affected          => STRING separated by comma (,)
             *
             *                  date                    => STRING
             *                  hour                    => STRING
             *                  action                  => STRING
             *
             *                  rollback                => BOOL default FALSE
             *                  approved                => BOOL default TRUE
             *                  id_user_approved        => INT default 0 => system
             *                  active                  => BOOL default FALSE
             *
             *                  sp_name                 => STRING,
             *                  sp_params               => ARRAY
             *
             * @examples :
             *
             *               $k =  $this->operator->create_operator([
                                "id_operator"              => '',
                                "id_company"               => '',
                                "id_operator_type"         => '',
                                "affected_table"           => '',
                                "affected_rows"            => '',
                                "query"                    => '',
                                "id_user_affected"         => '',
                                "date"                     => '',
                                "hour"                     => '',
                                "action"                   => '',
                                "rollback"                 => false,
                                "approved"                 => true ,
                                "id_user_approved"         => 0,
                                "active"                   => false,
                                "sp_name"                  => '',
                                "sp_params"                => []
                            ] );
             *
             *      Notas :
             *          -- $k devuelve un stdclass en este caso un campo llamado key_returned o count
                        -- colocar los todos los items "NO" es obligatorio solo los que se necesitaran
             *              los demas automaticamente agarraran su valor por defecto :)
             ***/



    public function create_operator (array $params  , $id_user_operator = NULL ){

            if(is_null($id_user_operator)) {
                $id_user_operator = parent::get()->id();
            }

            $log = $this->decode_; //clonamos el decode_ que contiene el objeto en si

            $params = (object) $params;

            $date                               = new DateTime('NOW');
            $gdate                              = $date->format("M-d-Y");
            $ghour                              = $date->format("H:m:s");

            $log->id_user_operator              = $id_user_operator;
            $log->table->table_name             = $params->affected_table ?? '';
            $log->table->affected_rows          = $params->affected_rows  ?? 0 ;
            $log->table->query                  = $params->query ?? '';
            $log->user->id_user_affected        = $params->id_user_affected ?? '';
            $log->user->users_affected          = $params->users_affected ?? '';
            $log->company->id_company_affected  = $params->id_company ?? '';
            $log->affected->date                = $params->date ?? $gdate ;
            $log->affected->hour                = $params->hour ?? $ghour ;
            $log->affected->action              = $params->action ?? NULL ;
            $log->status->rollback              = $params->rollback ?? FALSE ;
            $log->status->approved              = $params->approved ?? TRUE;
            $log->status->id_user_approved      = $params->id_user_approved ?? 0 ;
            $log->status->active                = $params->active ?? FALSE;
            $log->sp->name                      = $params->sp_name ?? '';
            $log->sp->params                    = $params->sp_params ?? [];

            if(isset($params->date) && $params->date == '' || $params->date == NULL ){
                $log->affected->date = $gdate;
            }

            if(isset($params->hour) && $params->hour == '' || $params->hour == NULL ){
                $log->affected->hour = $ghour;
            }

            $operator_id                        = $params->id_operator ?? '';
            $operator_type                      = $params->id_operator_type ?? 0;

            $e_type                             = $this->sp_operator_type->create;
            $sp                                 = $this->stored_procedures['sp_operator'];

            $instance                           = parent::get_instance();


        /**
                IN e_type					VARCHAR(3),
                IN i_op_type				VARCHAR(4),
                IN i_id_operator 			VARCHAR(255),
                IN i_id_user 				INT(11),
                IN i_affected_table 		VARCHAR(100),
                IN i_id_company			INT(11),
                IN i_log						TEXT ,
                IN e_id_op_log				INT(11)
         */



            $result   = $instance->db->query($sp , [
                    $e_type,
                    $operator_type,
                    $operator_id,
                    $id_user_operator,
                    $params->affected_table ?? '',
                    $params->id_company ?? '',
                    json_encode($log , JSON_HEX_TAG | JSON_HEX_QUOT),
                    0
            ])->result();


            return $result;


    }


    public function  create_insert_operator(
        $user ,
        $query ,
        $operator = '' ,
        $affected_rows = 0 ,
        $affected_table = '' )
    {


        $k =  $this->create_operator([
            "id_operator"              => $operator,
            "id_company"               => '',
            "id_operator_type"         => 'C',
            "affected_table"           => $affected_table,
            "affected_rows"            => $affected_rows,
            "query"                    => $query ,
            "id_user_affected"         => '',
            "date"                     => '',
            "hour"                     => '',
            "action"                   => $this->operator_actions->in,
            "rollback"                 => false,
            "approved"                 => false  ,
            "id_user_approved"         => 0,
            "active"                   => false,
            "sp_name"                  => 'NO STORED PROCEDURE ',
            "sp_params"                => []
        ] , $user );


        return $k ;

    }

    public function create_sp_basic_operator(
        $user ,
        $sp_name ,
        $operator = '',
        $sp_params = [],
        $affected_rows = 0 ,
        $affected_table = 0  )
    {


        $k =  $this->operator->create_operator([
            "id_operator"              => $operator,
            "id_company"               => '',
            "id_operator_type"         => 'C',
            "affected_table"           => $affected_table,
            "affected_rows"            => $affected_rows,
            "query"                    => 'No query (SP ONLY )',
            "id_user_affected"         => '',
            "date"                     => '',
            "hour"                     => '',
            "action"                   => $this->operator_actions->sp,
            "rollback"                 => false,
            "approved"                 => false  ,
            "id_user_approved"         => 0,
            "active"                   => false,
            "sp_name"                  => $sp_name,
            "sp_params"                => $sp_params
        ] , $user );



        return $k;

    }


    public function create_update_basic_operator(
        $user ,
        $query ,
        $operator = '',
        $affected_rows = 0 ,
        $affected_table = ''  )
    {


        $k =  $this->create_operator([
            "id_operator"              => $operator,
            "id_company"               => '',
            "id_operator_type"         => 'C',
            "affected_table"           => $affected_table,
            "affected_rows"            => $affected_rows,
            "query"                    => $query ,
            "id_user_affected"         => '',
            "date"                     => '',
            "hour"                     => '',
            "action"                   => $this->operator_actions->up,
            "rollback"                 => false,
            "approved"                 => false  ,
            "id_user_approved"         => 0,
            "active"                   => false,
            "sp_name"                  => 'NO STORED PROCEDURE ',
            "sp_params"                => []
        ] , $user );



        return $k;

    }




}